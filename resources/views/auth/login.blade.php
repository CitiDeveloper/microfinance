<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Studio | Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- ================== BEGIN core-css ================== -->
	<link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
	<!-- ================== END core-css ================== -->
</head>
<body>
	<div id="app" class="app app-full-height app-without-header">
		<div class="login">
			<div class="login-content">
				<form method="POST" action="{{ route('login') }}">
					@csrf
					
					<h1 class="text-center">Sign In</h1>
					<div class="text-muted text-center mb-4">
						For your protection, please verify your identity.
					</div>

					{{-- Email --}}
					<div class="mb-3">
						<label for="email" class="form-label">Email Address</label>
						<input type="email" 
							name="email" 
							id="email" 
							class="form-control form-control-lg fs-15px @error('email') is-invalid @enderror"
							value="{{ old('email') }}" 
							placeholder="username@address.com" 
							required 
							autofocus>
						@error('email')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					{{-- Password --}}
					<div class="mb-3">
						<div class="d-flex">
							<label for="password" class="form-label">Password</label>
							@if (Route::has('password.request'))
								<a href="{{ route('password.request') }}" class="ms-auto text-muted">Forgot password?</a>
							@endif
						</div>
						<input type="password" 
							name="password" 
							id="password" 
							class="form-control form-control-lg fs-15px @error('password') is-invalid @enderror"
							placeholder="Enter your password" 
							required>
						@error('password')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					{{-- Remember me --}}
					<div class="mb-3">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="remember" id="remember">
							<label class="form-check-label fw-500" for="remember">Remember me</label>
						</div>
					</div>

					{{-- Submit --}}
					<button type="submit" class="btn btn-theme btn-lg d-block w-100 fw-500 mb-3">Sign In</button>

					<div class="text-center text-muted">
						Don't have an account yet? 
						@if (Route::has('register'))
							<a href="{{ route('register') }}">Sign up</a>.
						@endif
					</div>
				</form>
			</div>
		</div>
		
		<!-- Scroll Top -->
		<a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
	</div>

	<!-- ================== BEGIN core-js ================== -->
	<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
	<script src="{{ asset('assets/js/app.min.js') }}"></script>
	<!-- ================== END core-js ================== -->
</body>
</html>
