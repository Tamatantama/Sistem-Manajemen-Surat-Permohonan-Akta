<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">

    <title>Buat Baru</title>
</head>
<body>
    <!-- Header -->
<div class="page-padding"> 
    
    <header>
            <div class="header">
                <a href="{{ route('surat.index') }}"><img class="header-logo" src="{{ asset('/images/logo.png') }}" alt=""></a>
                <div class="header-nav">
                    <a class="" href="{{ route('surat.index') }}" id="home">Beranda</a>
                    <a href="https://disdukcapil.pekalongankota.go.id/" id="our-profile">Profil Instansi</a>
                    <div class="dropdown">
                        <a class="dropbtn">My Profile</a>
                        <div class="dropdown-content">
                            <a href="{{ route('profile.my') }}">My Profile</a>
                            <a href="{{ route('user.index', Auth::user()->id) }}">Profil Users</a>
                        </div>
                    </div>
                    

                    <a href="#" class="btn btn-outline-light ml-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-1"></i>Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div>


            </div>
            
        </header>


    <div>
        

    <div class="padding"></div>
    <div class="padding"></div>


<form method="POST" action="{{ route('surat.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="nik">NIK</label>
        <input type="text" class="form-control" id="nik" name="nik" required>
    </div>
    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
    </div>
    <div class="form-group">
        <label for="tipe_surat">Tipe Surat</label>
        <input type="text" class="form-control" id="tipe_surat" name="tipe_surat" required>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" id="status" name="status" required>
            <option value="Dalam Proses">Dalam Proses</option>
            <option value="Selesai">Selesai</option>
        </select>
    </div>
    <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
    </div>
    <div class="form-group">
        <label for="file_path">File Path</label>
        <input type="file" name="file_path[]" class="form-control" multiple>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

    </div>
</body>
</html>




