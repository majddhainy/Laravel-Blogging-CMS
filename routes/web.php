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



// middleware auth is appliead for all routes inside this group

Route::middleware(['auth'])->group(function() {

Route::get('/home', 'HomeController@index')->name('home');
// using :: 'resource' u save routes for all functions inside CategoriesController automatically
// check php artisan route:list to make sure of what we are saying 
Route::resource('categories' , 'CategoriesController');
Route::resource('tags' , 'TagsController');
Route::resource('posts' , 'PostsController')->middleware('auth');
// a route for trashed posts because its not included in posts routes 
// no need for creating controller here directly return the view from here OR create new method in ur controller [BETTER]
// this route is to view all trashed posts
Route::get('/trashed-posts','PostsController@trashed')->name('posts.trashed');
//  SECURED FOR RESTORING POSTS 
Route::PUT('/restorepost/{post}','PostsController@restore')->name('posts.restore');


});

// those actions can only be done by admin !
Route::middleware(['auth' , 'admin'])->group(function() {
Route::get('/users','UsersController@index')->name('users.index');
Route::put('/users/{user}/changerole','UsersController@changerole')->name('users.changerole');
});