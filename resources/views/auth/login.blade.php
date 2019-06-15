@extends('layouts.auth')

@section('content')
	<div class="card-body">
		<form method="POST" action="{{ route('login') }}">
			@csrf
			<div class="form-group">
				<input class="form-control form-control-lg {{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}" id="username" type="text" placeholder="Username" autocomplete="off"
				name="email" value="{{ old('email') }}" required autofocus>
				@error('email')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
				@error('username')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror

			</div>

			<div class="form-group">
					<input class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" type="password" placeholder="Password" name="password" required autocomplete="current-password">
					@error('password')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
			</div>

			<div class="form-group">
					<label class="custom-control custom-checkbox">
							<input class="custom-control-input" type="checkbox"
							name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
							><span class="custom-control-label">Remember Me</span>
					</label>
			</div>

			<button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>

		</form>
	</div>
	<div class="card-footer bg-white p-0  ">
		<div class="card-footer-item card-footer-item-bordered">
			<a href="{{ route('password.request') }}" class="footer-link">Forgot Password</a>
		</div>
	</div>
@endsection