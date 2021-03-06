<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\posts\CreatePostRequest;
use App\Http\Requests\posts\UpdatePostRequest;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PostsController extends Controller
{
    public function __construct()
    {
        // middleware applied on create post page and storing a post (post request ! )
        $this->middleware('verifycategoriescount')->only(['create','store']);
    }
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
        $categories = Category::all();
        return view('posts.createoredit')->with('categories',$categories);
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
        $post->published_at = $data['published_at'];
        // $post->published_at = $data['published_at'];
        // category since its the name in the select
        $post->category_id = $data['category'];
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
        $categories = Category::all();
        $post = Post::find($id);
        return view('posts.createoredit')->with('post',$post)->with('categories',$categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {

        // Also here no Need to validate because it automatic will call the rules() fn//
        $data = $request->all();
        Post::where('id', $id)
        ->update(['title' => $data['title'],
                  'description' => $data['description'], 
                  'content' => $data['content'], 
                  'published_at' => $data['published_at'],
                  'category_id' => $data['category'],
        ]);

        if(isset($data['image'])){
            $post = Post::find($id);
            // easily here call ur function
            $post->deleteimage();
            $new_path = $data['image']->store('posts');
            Post::where('id', $id)->update(['image_path' => $new_path ]);
        }

        session()->flash('success','Post updated successfuly ');
        // also here in redirect u can just use route name better !

        return redirect(route('posts.index'));
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
            $post->deleteimage();
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
