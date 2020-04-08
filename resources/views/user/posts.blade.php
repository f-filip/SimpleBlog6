@extends('user.layout')
@section('head')

@endsection
@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="text-center">Posts</h2>
        @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
        @elseif(session('alert'))
        <div class="alert alert-danger">
          {{ session('alert') }}
        </div>
      @endif
      </div>
        <div class="col-md-6">
      </div>
    </div>
    <div class="row mt-2">
    <div class='col-md-6'>
    <!-- search filter -->
      <form class='form-inline' action="{!! route('user.post.filter') !!}" method="post">
      @method('post')
      @csrf

      <select placeholder="Enter name" class="selectpicker w-25" multiple name="category_id[]">
        <option disabled>Select category</option>       
        @foreach ($categories as $category)
          <option value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
      </select>

      <select class="form-control ml-1 w-25" name="sort_by"> 
        <option selected disabled>Sort by</option>
        <option value="0">Newest</option>
        <option value="1">Oldest</option>
      </select>

        <input class="btn btn-info ml-1" type="submit" value="Filter">
      </form>
    </div>
    <!-- end search filter -->
    <div class='col-md-4 float-right'>
      <a href="{!! route('user.posts') !!}" class="btn btn-info ml-2">Show all posts</a>
      <a class="btn btn-info ml-2" href="{!! route('user.post.create') !!}">Create new post</a>
    </div>
  </div>
    <div class="row mt-2">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Title</th>
            <th scope="col">Category</th>
            <th scope="col">Posted by</th>
            <th scope="col">Status</th>
            <th scope="col">Published at</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($posts as $post)
          <tr>
            <th scope="row">{{$post->id}}</th>
            <td>{{$post->title}}</td>
            <td>{{$post->category->name}}</td>
            <td>
                You
            </td>
            <td>{{ $post->published_at === null ? "Pending" : "Approved" }}</td>
            <td>{{ $post->published_at === null ? "---" : "$post->published_at" }}</td>
            <td>
                <a class="btn btn-primary" href="{!! route('user.post.edit', $post) !!}">Edit</a>
                <button class="btn btn-danger remove-record" value="delete" data-toggle="modal" data-target="#deleteModal" data-url="{!! route('user.post.delete', $post) !!}" data-id="{{$post->id}}">Delete</button>
            </td>
            @empty
              <tr><td>No result matching given parameters  </td></tr>
            @endforelse
         </tbody>
         <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Title</th>
          <th scope="col">Category</th>
          <th scope="col">Posted by</th>
          <th scope="col">Status</th>
          <th scope="col">Published at</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      </table>
    </div>
  </div>

</div> <!-- /#page-content-wrapper -->
</div> <!-- /#wrapper -->

<!-- Modal -->
@isset($post)
  <form action="{!! route('user.post.delete', $post) !!}" method="POST" class="remove-record-model">
    @method('delete')
    @csrf
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Czy na pewno chcesz usunąć post?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Tych zmian nie można cofnąć.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
        <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> Usuń</button>
      </div>
    </div>
  </div>
  </div>
  </form>
@endisset


<!-- Modal stop -->
@endsection

<script>

  $(function () {
    $('select').selectpicker();
});
</script>