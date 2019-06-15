@extends('layouts.auth')

@section('content')
  <h2  class="text-center">
    {{ __('Forgot Password') }}
  </h2>
	<div class="card-body">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
      {{ session('status') }}
    </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
      @csrf

			<p>Don't worry, we'll send you an email to reset your password.</p>
			<div class="form-group">
        <input placeholder="E-mail" class="form-control @error('email') is-invalid @enderror"
        type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <div class="form-group pt-1">
        <button class="btn btn-block btn-primary btn-xl">Reset Password</button>
      </div>
		</form>
	</div>
	<div class="card-footer text-center">
  <span>Have an account? <a href="{{route('login')}}">Log In</a></span>
	</div>
@endsection

