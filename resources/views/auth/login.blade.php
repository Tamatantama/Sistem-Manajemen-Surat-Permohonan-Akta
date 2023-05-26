@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <title>Document</title>
</head>
<body>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>

        <script>
            // Close the success message after 3 seconds
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 3000);

            // Redirect to login page after 3 seconds
            setTimeout(function() {
                window.location.href = '{{ route("login") }}';
            }, 3000);
        </script>
    @endif

  <div class="container-login">
  <div class="card-login">
        <div class="card-login-header">{{ __('Login') }}</div>

        <div class="card-login-body">
            <form class="form-login" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-login-group row">
                    <label for="email" class="col-md-4 col-form-login-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-login-group row">
                    <label for="password" class="col-md-4 col-form-login-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-login-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-login-check">
                            <input class="form-login-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-login-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-login-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn-login btn-primary">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>


  </div>

</body>
</html>
@endsection