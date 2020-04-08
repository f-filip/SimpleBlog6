@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @if ($message = Session::get('success'))
                <div class="custom-alerts alert alert-success fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    {!! $message !!}
                </div>
                <?php Session::forget('success');?>
                @endif                
                <div class="panel-heading">All Posts</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                    	<thead>
                    		<tr>                    			
	                    		<th>Title</th>
	                    		<th>Description</th>
	                    		<th>Action</th>
                    		</tr>
                    	</thead>
                    	<tbody>
                            @foreach($post as $key => $value)
                                <tr>
                                    <td>{!! $value->title !!}</td>
                                    <td>{!! $value->description !!}</td>
                                    <td>
<a class="btn btn-danger waves-effect waves-light remove-record" data-toggle="modal" data-url="{!! URL::route('post-delete', $value->id) !!}" data-id="{{$value->id}}" data-target="#custom-width-modal">Delete</a>
                                    </td>
                                </tr>
                            @endforeach                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Model -->
<form action="" method="delete" class="remove-record-model">
    <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="custom-width-modalLabel">Delete Record</h4>
                </div>
                <div class="modal-body">
                    <h4>You Want You Sure Delete This Record?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
<script src="{{ asset('custom.js') }}"></script>
@endsection	
	


$(document).ready(function(){
	// For A Delete Record Popup
	$('.remove-record').click(function() {
		var id = $(this).attr('data-id');
		var url = $(this).attr('data-url');
		var token = CSRF_TOKEN;
		$(".remove-record-model").attr("action",url);
		$('body').find('.remove-record-model').append('<input name="_token" type="hidden" value="'+ token +'">');
		$('body').find('.remove-record-model').append('<input name="_method" type="hidden" value="DELETE">');
		$('body').find('.remove-record-model').append('<input name="id" type="hidden" value="'+ id +'">');
	});

	$('.remove-data-from-delete-form').click(function() {
		$('body').find('.remove-record-model').find( "input" ).remove();
	});
	$('.modal').click(function() {
		// $('body').find('.remove-record-model').find( "input" ).remove();
	});
});
	


