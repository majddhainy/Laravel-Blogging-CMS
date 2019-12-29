@extends('layouts.app')

{{-- Note here we can use the same file for editing / creating Posts to reduce number of files --}}

{{-- U can use trix editor nice for inserting content but u have to style/resize it in a good way
code : 
<input type="hidden"  id="content"  name="content" type="text">
<trix-editor  class="trix-content" width="20" placeholder="Content" input="content"></trix-editor>

and include css & js by typing [] cdn trix editor ] in google --}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>  
                            @endforeach
                        </ul>
                    </div>

                @endif
                <div class="card">
                {{-- if object category is sent so we are editing else we are creating  --}}
                <div class="card-header">{{ isset($post) ? 'Edit Post' : 'Create Post'}}</div>

                    <div class="card-body">
                        {{-- in action u can just say the name of the route  --}}
                        {{-- also the name differs if editing or creating --}}
                        <form method="post" enctype="multipart/form-data" action="{{ isset($post) ? route('posts.update' , $post->id )   : route('posts.store') }}">
                            @if (isset($post))
                                @method('PUT')
                            @endif
                            {{-- never forget csrf token ! --}}
                            @csrf
                            <div class="form-group">
                                {{-- put value if editing empty if creating --}}
                                <input name="title" placeholder="Title" type="text" class="form-control" value="{{ isset($post) ? $post->title : ''}}">
                            </div>
                            <div class="form-group">
                                {{-- put value if editing empty if creating --}}
                                <input name="description" placeholder="Description" type="text" class="form-control" value="{{ isset($post) ? $post->description : ''}}">
                            </div>
                            <div class="form-group">
                                {{-- put value if editing empty if creating --}}
                            <textarea rows="5" cols="5" name="content" placeholder="Content" type="text" class="form-control">@if(isset($post)){{$post->content}}@endif</textarea>
                            </div>
                            <div class="form-group">
                                {{-- put value if editing empty if creating --}}
                                <input id="published_at" name="published_at" value="{{ (isset($post) && $post->published_at != null) ? $post->published_at : 'Published At'}}"  type="text" class="form-control" >
                            </div>
                            <div class="form-group">
                                    <select class="form-control" name="category">
                                        @foreach ($categories as $category)
                                            {{-- So here we are grabbing all categories that are sent by controller
                                            and we will check if there is a post also sent so we are editing not creating
                                            here we wanna make sure if the cat id is sam as post_cat_id so make it selected --}}
                                            <option @if (isset($post))@if($category->id == $post->category_id) selected="selected" @endif @endif  value="{{ $category->id }}"> {{ $category->name }} </option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                @if (isset($post))
                                    @if(isset($post->image_path))
                                        <img class="mx-2 my-2" width="150" height="150" src="{{ asset( "storage/" . $post->image_path) }}" />
                                    @endif
                                @endif
                                <input id="image"  name="image"  type="file" class="form-control">
                            </div>
                            <button type="submit"  class="btn btn-success float-right"> {{ isset($post) ? 'Update Post' : 'Add Post'}} </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- linking css and javascript for flatpickr --}}
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>   
    <script>
        // calling the picker and allowing time 
        flatpickr('#published_at',{
            enableTime : true
        });
    </script>
@endsection
