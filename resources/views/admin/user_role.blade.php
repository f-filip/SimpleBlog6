@extends('admin.layout')
@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="text-center">Roles</h2>
        @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif
      </div>
      <div class="col-md-6">
       
      </div>
    </div>
    <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">email</th>
            <th scope="col">role</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
          <tr>
            <th scope="row">{{$user->id}}</th>
            <td>{{$user->email}}</td>
            <td>
              <form method="POST" action="{{route('admin.role.update',$user)}}">
                @csrf
                @method('PUT')
                    <select class="form-control" name="role" id="role">
                      @foreach ($roles as $role)
                        <option id="{{$role->id}}" value="{{$role->id}}">{{$role->name}}</option>
                      @endforeach
                    </select>
            </td>
            <td>
              <input type="submit" value="update" class="btn btn-primary">
            </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div> <!-- /#page-content-wrapper -->
</div> <!-- /#wrapper -->


<!-- Modal stop -->
@endsection