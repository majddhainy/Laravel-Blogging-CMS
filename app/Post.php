<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use SoftDeletes;
    
    
    // define function here u may use it many times and maybe the code is longer (deleting from cloud for example ..)
    public function deleteimage() {
        Storage::delete($this->image_path);
    }


    // this is a relation ship that each post belong to 1 category
    // function name is small letters of Model name
    public function category(){
       return $this->belongsTo(Category::class);
    }
}
