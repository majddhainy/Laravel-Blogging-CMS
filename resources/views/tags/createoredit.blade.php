@extends('layouts.app')

{{-- Note here we can use the same file for editing / creating tags to reduce number of files --}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                @include('partials.errors')

                <div class="card">
                {{-- if object tag is sent so we are editing else we are creating  --}}
                <div class="card-header">{{ isset($tag) ? 'Edit tag' : 'Create tag'}}</div>

                    <div class="card-body">
                        {{-- in action u can just say the name of the route  --}}
                        {{-- also the name differs if editing or creating --}}
                        <form method="post" action="{{ isset($tag) ? route('tags.update' , $tag->id )   : route('tags.store') }}">
                            @if (isset($tag))
                                @method('PUT')
                            @endif
                            {{-- never forget csrf token ! --}}
                            @csrf
                            <div class="form-group">
                                {{-- put value if editing empty if creating --}}
                                <input name="name" placeholder="Name" type="text" class="form-control" value="{{ isset($tag) ? $tag->name : ''}}">
                            </div>
                            <button type="submit"  class="btn btn-success float-right"> {{ isset($tag) ? 'Update tag' : 'Add tag'}} </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


