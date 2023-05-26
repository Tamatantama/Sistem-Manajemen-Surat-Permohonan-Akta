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
    <div class="page-padding">
        <header>
                <div class="header">
                    <a href="{{ route('surat.index') }}"><img class="header-logo" src="{{ asset('/images/logo.png') }}" alt=""></a>
                    <div class="header-nav">
                        <a class="" href="{{ route('surat.index') }}" id="home">Beranda</a>
                        <a href="https://disdukcapil.pekalongankota.go.id/" id="our-profile">Profil Instansi</a>
                        <a  href="https://disdukcapil.pekalongankota.go.id/"id="message-us">Hubungi kami</a>
                        <a class="active" href="{{ route('profile.my') }}">Profil Saya</a>
                        
                        <a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                                <button class="btn btn-outline-light ml-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt mr-1"></i>Logout
                                </button>
                            </form>
                        </a>
                    </div>
                </div>
                
        </header>

    
            <div class="padding"></div>
        <body>
            <div class="">
                <h1>Profil Saya</h1>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>{{ $user->role }}</td>
                        </tr>
                        <!-- Tambahkan informasi profil lainnya sesuai kebutuhan -->
                    </tbody>
                </table>
            </div>
    </div>
    </body>
    </html>
@endsection
