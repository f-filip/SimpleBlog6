@extends('admin.layout')
@section('content')
<div class="container">
    <div class="row">
    <div class="col-md-6">
      <h2 class="text-center">Create new post</h2>
    </div>
    </div>
    <div class="row">
        <div class="col-md-6">
    @foreach ($errors->all() as $error)
        <div class='alert alert-danger'>{{ $error }}</div>
    @endforeach
    <form method="POST" action="{{route('user.post.store')}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')  
        Slug:</br><input type="text" class="form-control" name="slug" value="{{ old('slug') }}" >
        </br>Title: </br><input class="form-control" type="text" name="title" value="{{ old('title') }}" >
        </br>Excerpt:</br> <input class="form-control" type="text" name="excerpt" value="{{ old('excerpt') }}" >
        </br>Category:</br>
        <select class="form-control" id="category_id" name="category_id">
        @foreach ($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
            </select> 
            </br>Body</br><textarea id="body" class="form-control" name="body">{{ old('body') }}</textarea>
            </br>Tags:</br>
                <select class="custom-select" id="tags" name="tags[]" multiple>
            @foreach ($tags as $tag)
                <option name="{{$tag->id}}" value="{{$tag->id}}">{{$tag->name}}</option>
            @endforeach
                </select> 
                </br><input class="btn btn-primary mt-2" type='submit' value='Store'>
    </form>
    </div>
        </div>
    </div>          
</div> <!-- /#page-content-wrapper -->
</div> <!-- /#wrapper -->
@endsection

