<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\categories\CreateCategoryRequest;
use App\Http\Requests\categories\UpdateCategoryRequest;

// using php artisan make:controller CategoriesController --resourse
// it automatically create all functionalaties inside the controller
// show edit destory ....etc 
class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.categories')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.createoredit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // here we changed type from Request to CreateCategoryRequest ! 
    // so laravel automatically call the rules function in our request class ... 
    // every check on the request will be kept in CreateCategoryRequest class not here ! 
    public function store(CreateCategoryRequest $request)
    {

        // dont validate here its better to create new request ! 



        // dd($request->all());
        $data = $request->all();
        $category = new Category();
        $category->name = $data['name'];
        $category->save();

        // Note some people use 
        // Category::create($request->all());
        // its dangerous here because u are inserting 
        // all data comming from the request in the database ! hackers may add some paramters ... 
        //if u want to use the static method create u have to declare an array fillable array in the Model


        session()->flash('success','Category created successfuly ');
        // also here in redirect u can just use route name better !
        return redirect(route('categories.index'));


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
        return redirect(route('categories.index'));
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
        $category = Category::find($id);
        return view('categories.createoredit')->with('category',$category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {

        // Also here no Need to validate because it automatic will call the rules() fn//
        $data = $request->all();
        Category::where('id', $id)
        ->update(['name' => $data['name'] ]);

        session()->flash('success','Category updated successfuly ');
        // also here in redirect u can just use route name better !

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $category = Category::find($id);
       if($category->posts->count() != 0){
            session()->flash('error','Category cannot be deleted because it contain some posts ');
            return redirect(route('categories.index'));
       }
       else {
        $category->delete();

        session()->flash('success','Category deleted successfuly ');
        return redirect(route('categories.index'));
       }
    }
}
