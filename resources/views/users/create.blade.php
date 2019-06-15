@extends('layouts.app')

@section('title', 'User Create')
@section('pagetitle', 'User Create')
@section('button')
<a href="{{route('users.index')}}" class="float-right btn btn-sm btn-space btn-primary">All Users</a>
@endsection

@section('breadcumb')
  <li class="breadcrumb-item">
    <a href="{{route('users.index')}}" class="breadcrumb-link">All Users</a>
  </li>
  <li class="breadcrumb-item">User Create</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-12">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('users.store') }}">
          @csrf

          <div class="form-group">
            <label for="name" class="@error('name') text-danger @enderror">
              Name
              @error('name')
              <br>{{ $message }}
              @enderror
            </label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
          </div>

          <div class="form-group">
            <label for="username" class="@error('username') text-danger @enderror">
              Username
              @error('username')
              <br>{{ $message }}
              @enderror
            </label>
            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" value="{{ old('username') }}" required>
          </div>

          <div class="form-group">
            <label for="email" class="@error('email') text-danger @enderror">
              Email
              @error('email')
              <br>{{ $message }}
              @enderror
            </label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
          </div>

          <div class="form-group">
            <label for="password" class="@error('password') text-danger @enderror">
              Password
              @error('password')
              <br>{{ $message }}
              @enderror
            </label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" value="{{ old('password') }}" required autocomplete="name" autofocus>
          </div>

          <div class="form-group">
            <label for="password-confirm">Confirm Password</label>
            <input id="password-confirm" type="password" class="form-control" placeholder="Password" name="password_confirmation" value="{{ old('password') }}" required autocomplete="new-password" autofocus>
          </div>

          <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role">
              <option value="">Select Role</option>
              <option value="A">Admin</option>
            </select>
          </div>

          <div class="row">
            <div class="col-sm-6 ml-1">
              <p class="text-left">
                <button type="submit" class="btn btn-space btn-primary">Submit</button>
              </p>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
