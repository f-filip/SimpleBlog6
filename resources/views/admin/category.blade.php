@extends('admin.layout')
@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="text-center">Category</h2>
        @if (session('status'))
          <div class="alert alert-success">
          {{ session('status') }}
          </div>
      @endif
      @foreach ($errors->all() as $error)
        <div class='alert alert-danger'>{{ $error }}</div>
      @endforeach
      </div>
      <div class="col-md-6">
        <form method="POST" action="{{route('admin.category.store')}}">
          @csrf
          @method('PUT')
          <div class="input-group mb-3 mt-1">
            <input name="name" type="text" class="form-control" placeholder="New category name" aria-label="New category name" aria-describedby="button-addon2" required>
            <div class="input-group-append">
              <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i class="far fa-plus-square"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($categories as $category)
          <tr>
            <th scope="row">{{$category->id}}</th>
            <td>{{$category->name}}</td>
            <td>
              <form method="POST" action="{!! route('admin.category.update', $category) !!}">
                @csrf
                @method('PUT')
                <div class="input-group">
                  <input name="name" type="text" class="form-control" placeholder="Change category name" aria-label="Change category name"aria-describedby="button-addon2" required>
                  <div class="input-group-append">
                    <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="far fa-edit"></i></button>
                  </form>
                    <button class="btn btn-outline-danger remove-record" type="button" data-toggle="modal" data-target="#deleteModal" 
                    data-url="{!! route('admin.category.delete', $category) !!}" data-id="{{$category->id}}" ><i class="far fa-trash-alt"></i></button>
                  </div>
                </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div> <!-- /#page-content-wrapper -->
</div> <!-- /#wrapper -->

<!-- Modal -->
<form action="{!! route('admin.category.delete', $category) !!}" method="POST" class="remove-record-model">
@method('delete')
@csrf
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Czy na pewno chcesz usunąć kategorię?</h5>
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
<!-- Modal stop -->
@endsection

@section('script')
<script src="{{ asset('/js/custom.js') }}"></script>
@endsection	