@extends('layouts.app')

@section('title', 'User Edit')
@section('pagetitle', 'User Edit')
@section('button')
<a href="{{route('users.index')}}" class="float-right btn btn-sm btn-space btn-primary">All Users</a>
@endsection

@section('breadcumb')
  <li class="breadcrumb-item">
    <a href="{{route('users.index')}}" class="breadcrumb-link">All Users</a>
  </li>
  <li class="breadcrumb-item active" aria-current="page">User Edit</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-12">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('users.update',$data->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label for="name" class="@error('name') text-danger @enderror">
              Name
              @error('name')
              <br>{{ $message }}
              @enderror
            </label>
            <input id="name" value="{{$data->name}}" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
          </div>

          <div class="form-group">
            <label for="username" class="@error('username') text-danger @enderror">
              Username
              @error('username')
              <br>{{ $message }}
              @enderror
            </label>
            <input id="username" value="{{$data->username}}" type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" value="{{ old('username') }}" required>
          </div>

          <div class="form-group">
            <label for="password" class="@error('password') text-danger @enderror">
              Password
              @error('password')
              <br>{{ $message }}
              @enderror
            </label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password">
          </div>

          <div class="form-group">
            <label for="password-confirm">Confirm Password</label>
            <input id="password-confirm" type="password" class="form-control" placeholder="Password" name="password_confirmation">
          </div>

          <div class="form-group">
            <label for="avatar">Avatar</label>
            <input id="avatar" type="file" class="form-control" placeholder="Avatar" name="avatar">
          </div>

          <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role" value="{{$data->role}}">
              <option value="">Select Role</option>
              <option value="A" @if($data->role == 'A') {{'selected'}}@endif>Admin</option>
            </select>
          </div>

          <div class="row">
            <div class="col-sm-6 ml-1">
              <p class="text-left">
                <button type="submit" class="btn btn-space btn-primary">Update</button>
              </p>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
