<?php

namespace App\Http\Controllers;
use App\Tag;
use App\Http\Requests\tags\CreateTagRequest;
use App\Http\Requests\tags\UpdateTagRequest;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return view('tags.tags')->with('tags', $tags);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.createoredit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTagRequest $request)
    {
        // dont validate here its better to create new request ! 



        // dd($request->all());
        $data = $request->all();
        $tag = new Tag();
        $tag->name = $data['name'];
        $tag->save();

        // Note some people use 
        // tag::create($request->all());
        // its dangerous here because u are inserting 
        // all data comming from the request in the database ! hackers may add some paramters ... 
        //if u want to use the static method create u have to declare an array fillable array in the Model


        session()->flash('success','tag created successfuly ');
        // also here in redirect u can just use route name better !
        return redirect(route('tags.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // here we don't need to show a specefic category so no need for it
        return redirect(route('tags.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         // Note : u can use ROUTE MODEL BINDING HERE 
         $tag = Tag::find($id);
         return view('tags.createoredit')->with('tag',$tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, $id)
    {
           // Also here no Need to validate because it automatic will call the rules() fn//
           $data = $request->all();
           Tag::where('id', $id)
           ->update(['name' => $data['name'] ]);
   
           session()->flash('success','Tag updated successfuly ');
           // also here in redirect u can just use route name better !
   
           return redirect(route('tags.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        // if($tag->post->count() != 0){
        //     session()->flash('error','Category cannot be deleted because it contain some posts ');
        //     return redirect(route('categories.index'));
        // }
        $tag->delete();
 
        session()->flash('success','Tag deleted successfuly ');
        return redirect(route('tags.index'));
    }
}
