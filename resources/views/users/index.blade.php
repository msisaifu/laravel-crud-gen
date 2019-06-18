@extends('layouts.app')
@section('title', 'Users')
@section('pagetitle', 'All Users')
@section('button')
<a href="{{route('users.create')}}" class="float-right btn btn-sm btn-space btn-primary">Add New</a>
@endsection
@section('breadcumb')
  <li class="breadcrumb-item active" aria-current="page">Users</li>
@endsection
@push('custom-js')
<script>
	$(document).ready(function(){
		$("#message").hide(4000)
		$("#message").show(500)
		$("#message").hide(500)
		$("#message").show(500)
		$("#message").hide(500)
	})
</script>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="card-header">
				<form action="{{route('users.index')}}" method="GET" style="inline">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Name, Email" name="q" value="{{$q??''}}">
						<div class="input-group-append be-addon">
							<select class="form-control" name="role" id="">
								<option value="">Any Role</option>
								<option value="A">A</option>
								<option value="U">U</option>
							</select>
							<button type="submit" class="btn btn-sm btn-danger">
								<i class="fa fa-search  " style=""></i>
								Search
							</button>
						</div>
					</div>
				</form>
			</div>

			<div class="card-body">
				@if(session('message'))
					<div id="message" class="alert alert-success">{{session('message')}}</div>
				@endif

				<table class="table">
					<thead>
						<tr>
								<th>#</th>
								<th>Name</th>
								<th>Email</th>
								<th>Avatar</th>
								<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@forelse($data as $record)
						<tr class="active">
							<th scope="row">{{$loop->iteration}}</th>
							<td>{{$record->name}}</td>
							<td>{{$record->email}}</td>
							<td>@if($record->avatar) <img src="{{asset('uploads/'.$record->avatar)}}" alt="" class="img-responsive" height="100" width="100">@endif</td>
							<td>
							@if(Auth::id() == $record->id)
								<a class="btn btn-xs btn-info" href="{{route('users.edit',$record->id)}}">
									<i class="fas fa-edit"></i></a>
							@endif
							@if(Auth::user()->role == 'A' && Auth::id() != $record->id && !$record->deleted_at)
								<a class="btn btn-xs btn-danger" href="#"
										onclick="event.preventDefault();
										document.getElementById('user-ban-{{$record->id}}').submit();">
									<i class="fas fa-ban"></i></a>
									<form id="user-ban-{{$record->id}}" action="{{route('users.destroy',$record->id)}}" method="POST" style="display: none;">
										@csrf
										@method('DELETE')
									</form>
							@endif

							@if(Auth::user()->role == 'A' && Auth::id() != $record->id && $record->deleted_at)
								<a class="btn btn-xs btn-success" href="#"
										onclick="event.preventDefault();
										document.getElementById('user-unban-{{$record->id}}').submit();">
									<i class="fas fa-unlock"></i></a>
									<form id="user-unban-{{$record->id}}" action="{{route('users.destroy',$record->id)}}" method="POST" style="display: none;">
										@csrf
										@method('DELETE')
									</form>
							@endif


							</td>
						</tr>
						@empty
							<tr class="active">
								<td>
									No records found
								</td>
							</tr>
						@endforelse
						<tr>
							@if(isset($data->customPaginate))
								{!! $data->customPaginate !!}
							@else
								{{ $data->links() }}
							@endif
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection