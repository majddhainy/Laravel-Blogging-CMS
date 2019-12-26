<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Category;
use App\Http\Controllers\CategoriesController;
//use Illuminate\Routing\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// using :: resource u save routes for all functions inside CategoriesController automatically
// check php artisan route:list to make sure of what we are saying 
Route::resource('categories' , 'CategoriesController');
Route::resource('posts' , 'PostsController');
