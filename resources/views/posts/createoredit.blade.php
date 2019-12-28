@extends('layouts.app')

{{-- Note here we can use the same file for editing / creating categories to reduce number of files --}}

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
                                <input name="published_at" placeholder="Published At" type="text" class="form-control" value="{{ isset($post) ? $post->published_at : ''}}">
                            </div>
                            <div class="form-group">
                                <label for="image">Post Image</label>
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


