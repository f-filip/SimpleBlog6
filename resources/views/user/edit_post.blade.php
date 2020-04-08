@extends('user.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
        <h2 class="text-center">Edit post</h2>
        </div>
    </div>
    <div class="row">
    @foreach ($errors->all() as $error)
        <div class='alert alert-danger'>{{ $error }}</div>
    @endforeach
    <form method="POST" action="{!! route('user.post.update',$post) !!}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
            Slug:</br><input class="form-control"  type="text" name="slug" value="{{$post->slug}}" >
            </br>Title: </br><input class="form-control"  type="text" name="title" value="{{$post->title}}">
            </br>Excerpt:</br> <input class="form-control"  type="text" name="excerpt" value="{{$post->excerpt}}" >
            </br>Category:</br>
            <select class="form-control" id="category_id" name="category_id">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}" {{ $category->id === $post->category->id ? "selected='selected'" : "" }}>{{$category->name}}</option>
                @endforeach
            </select> 
            </br>Body</br><textarea class="form-control" id="body" name="body">{{$post->body}}</textarea>
    
    
        </br>Tags:</br>
        
        <select class="form-control"  id="tags" name="tags[]" multiple>
            @foreach ($tags as $tag)
                <option name="{{$tag->id}}" value="{{$tag->id}}"
                    @foreach ($postTags as $postTag)
                        {{ $postTag->id === $tag->id ? "selected" : "" }}
                    @endforeach
                    >{{$tag->name}}</option>
            @endforeach
        </select>
            </br><input class='btn btn-primary' type='submit' value='Update'>
        </form>
        </div>
    </div>          
</div> <!-- /#page-content-wrapper -->
</div> <!-- /#wrapper -->
@endsection

