<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(){
        return view('users.users')->with('users',User::all());
    }

    public function changerole(User $user){
        // change role to admin or to user  NOTE route model bining is used here 
        if( $user->role == 'admin'){
            $user->role = 'writer';
            $user->save();
            session()->flash('success','User changed to writer successfuly');
            return redirect(route('users.index'));
        }

        else {
            $user->role = 'admin';
            $user->save();
            session()->flash('success','User changed to admin successfuly');
            return redirect(route('users.index'));
        }


    }
}
