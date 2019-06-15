@extends('layouts.auth')

@section('content')
	<h2  class="text-center">
		{{ __('Reset Password') }}
	</h2>

	<div class="card-body">
			<form method="POST" action="{{ route('password.update') }}">
					@csrf

					<input type="hidden" name="token" value="{{ $token }}">

					<div class="form-group">
						<input class="form-control form-control-lg @error('email') is-invalid @enderror"" id="email" type="email" placeholder="Email" autocomplete="off"
						name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

						@error('email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror

					</div>

					<div class="form-group">
							<input class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" type="password" placeholder="Password" name="password" required autocomplete="new-password">

							@error('password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
					</div>

					<div class="form-group">
							<input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="Confirm password" required autocomplete="new-password">
					</div>
					<button type="submit" class="btn btn-primary btn-lg btn-block">Reset Password</button>
			</form>


	</div>
	<div class="card-footer text-center">
  <span>Have an account? <a href="{{route('login')}}">Log In</a></span>
	</div>
@endsection
