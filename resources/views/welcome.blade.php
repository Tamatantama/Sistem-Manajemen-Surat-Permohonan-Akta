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
<body class="body-welcome">
@if (Route::has('login'))
    <div class="top-right links">
        @auth
            <script>window.location = "{{ url('/index') }}";</script>
        @else
            <div class="bg-image" style="background-image: url('/images/bg.png');"> 
                <div class="overlay"></div>
                <div class="container-welcome">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card-welcome shadow">
                                <div class="card-welcome-body">
                                    <div class="padding"></div>
                                    <img src="/images/logo.png" alt="Logo" height="100px">
                                    <h1>Welcome</h1>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed dictum est, non sagittis arcu. Duis iaculis eu ipsum id mattis.</p>
                                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
    </div>
@endif


</body>
</html>
@endsection