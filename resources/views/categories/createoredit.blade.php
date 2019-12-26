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
                <div class="card-header">{{ isset($category) ? 'Edit Category' : 'Create Category'}}</div>

                    <div class="card-body">
                        {{-- in action u can just say the name of the route  --}}
                        {{-- also the name differs if editing or creating --}}
                        <form method="post" action="{{ isset($category) ? route('categories.update' , $category->id )   : route('categories.store') }}">
                            @if (isset($category))
                                @method('PUT')
                            @endif
                            {{-- never forget csrf token ! --}}
                            @csrf
                            <div class="form-group">
                                {{-- put value if editing empty if creating --}}
                                <input name="name" placeholder="Name" type="text" class="form-control" value="{{ isset($category) ? $category->name : ''}}">
                            </div>
                            <button type="submit"  class="btn btn-success float-right"> {{ isset($category) ? 'Update Category' : 'Add Category'}} </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


