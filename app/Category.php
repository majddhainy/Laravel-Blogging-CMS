<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     // this is a relationship that each category has many posts
    // function name is small letters of Model name
    public function posts(){
        return $this->hasMany(Post::class);
    }
}
