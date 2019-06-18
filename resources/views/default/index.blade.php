@extends('layouts.app')
@section('title', "{$model}")
@section('pagetitle', "All ".str_plural($model))
@section('button')
<a href="{{route(str_plural(strtolower($model)).'.create')}}" class="float-right btn btn-sm btn-space btn-primary">Add New</a>
@endsection
@section('breadcumb')
  <li class="breadcrumb-item active" aria-current="page">{{str_plural($model)}}</li>
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
	function deleteForm(id){
		var r = confirm('Are you sure to delete data?');
		if(r){
			event.preventDefault();
			document.getElementById('delete-form-'+id).submit();
		}
	}
</script>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="card-header">
				<form action="{{route(str_plural(strtolower($model)).".index")}}" method="GET" style="inline">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Name" name="q" value="{{$q??''}}">
						<div class="input-group-append be-addon">
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
								@foreach($columns as $val)
								<th>{{$val}}</th>
								@endforeach
								<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@forelse($data as $record)
						<tr class="active">
							<th scope="row">{{$loop->iteration}}</th>
							@foreach($columns as $val)
							<td>{{$record->$val}}</td>
							@endforeach

							<td>
								<a class="btn btn-xs btn-info" href="{{route(str_plural(strtolower($model)).'.edit',$record->id)}}">
									<i class="fas fa-edit"></i></a>
								<a class="btn btn-xs btn-danger" href="#"
										onclick="deleteForm({{$record->id}})">
									<i class="fas fa-trash"></i></a>
									<form id="delete-form-{{$record->id}}" action="{{route(str_plural(strtolower($model)).'.destroy',$record->id)}}" method="POST" style="display: none;">
										@csrf
										@method('DELETE')
									</form>
							</td>
						</tr>
						@empty
							<tr class="active">
								<td>
									No records found
								</td>
							</tr>
						@endforelse
						<tr class="active">

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