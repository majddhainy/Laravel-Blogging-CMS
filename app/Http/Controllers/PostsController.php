<?php

namespace App\Http\Controllers;

use App\Http\Requests\posts\CreatePostRequest;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allposts = Post::all();
        return view('posts.posts')->with('posts',$allposts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.createoredit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        //upload image
        // dd($request->image);
        // dd($request->image->store('posts'));

        $image_path = $request->image->store('posts');

        // create the post

        $data = $request->all();
        $post = new Post();
        $post->title = $data['title'];
        $post->description = $data['description'];
        $post->content = $data['content'];
        // $post->published_at = $data['published_at'];
        $post->image_path = $image_path;
        $post->save();
        //flash a message
        session()->flash('success','Post Created Successfuly');
        //redirect the user to the posts
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.createoredit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //return only trashed posts to the view
    public function trashed(){
        $trashedposts = Post::onlyTrashed()->get();
        return view('posts.trashed-posts')->with('trashedposts',$trashedposts);
    }

    //restore a trashed post 
    public function restore($id){
        // find all including trashed
        $post = Post::withTrashed()->find($id);
        // retore the post 
        $post->restore();
        session()->flash('success','Post Restored Successfuly');
        return redirect(route('posts.trashed'));
    }
    public function destroy($id)
    {
        $post = Post::withTrashed()->find($id);

        if($post->trashed()){
            // deleting the image !
            Storage::delete($post->image_path);
            // permanent delete
            $post->forceDelete();
            session()->flash('success','Post Deleted Successfuly');
            return redirect(route('posts.trashed'));
        }

        else {
            $post->delete();
            session()->flash('success','Post Trashed Successfuly');
            return redirect(route('posts.index'));
        }

    }
}
