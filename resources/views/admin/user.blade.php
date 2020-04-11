@extends('admin.layout')
@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="text-center">User</h2>
        @if (session('status'))
          <div class="alert alert-success">
            {{ session('status') }}
          </div>
        @elseif(session('alert'))
        <div class="alert alert-danger">
          {{ session('alert') }}
        </div>
        @endif
        @foreach ($errors->all() as $error)
        <div class='alert alert-danger'>{{ $error }}</div>
      @endforeach
      </div>
      <div class="col-md-6">
       
      </div>
    </div>
    <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">User Details</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
            <tr>
              <th scope="row">{{$user->id}}</th>
              <td>{{$user->email}}</td>
              <td>{{$user->roles->first()->name}}</td>
              <td><button class="btn btn-primary" data-toggle="modal" data-target='#detailModal'
                 data-name="{{$user->name}}" data-email="{{$user->email}}" data-user_id="{{$user->id}}" data-user_role="{{$user->roles->first()->name}}">Show/Edit</button></td>
              <td>
                <button class="btn btn-danger remove-record" value="delete" data-toggle="modal" data-user_id="{{$user->id}}" data-target="#deleteModal" data-url="{!! route('admin.user.delete', $user) !!}" data-id="{{$user->id}}">Delete</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div> <!-- /#page-content-wrapper -->
</div> <!-- /#wrapper -->

<!-- Modal delete -->
<form action="{!! route('admin.user.delete') !!}" method="POST" class="remove-record-model">
  @method('delete')
  @csrf
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Do you want to delete User?</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <input type="hidden" name="user_id" name="user_id" id="user_id">
      This changes cannot be restored.
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> Delete</button>
    </div>
  </div>
</div>
</div>
</form>
<!-- Modal stop -->

<!-- Modal details -->
<form action="{!! route('admin.user.update') !!}" method="POST">
  @method('put')
  @csrf
<div class="modal fade" id='detailModal' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">User details</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <input type="hidden" name="user_id" id="user_id">
      Name:<input type="text" class="form-control" name="name" id="name" >
      E-mail:<input type="email" class="form-control" name="email" id="email">
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> Update</button>
    </div>
  </div>
</div>
</div>
</form>
<!-- Modal stop -->
<script>
$('#detailModal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) 
  var name = button.data('name')
  var email = button.data('email') 
  var user_id = button.data('user_id')  

	var modal = $(this)
  modal.find('.modal-body #name').val(name)
  modal.find('.modal-body #email').val(email)
  modal.find('.modal-body #user_id').val(user_id)
  })

</script>
<script>
  $('#deleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var user_id = button.data('user_id')  
    var modal = $(this)
    modal.find('.modal-body #user_id').val(user_id)
    })
  
</script>
@endsection


