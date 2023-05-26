<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <title>Ubah Data</title>
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

    <div class="padding"></div>
    <div class="padding"></div>

    <div class="container-2">
        <div class="data-container">
            <div class="card-body">
                <div class="card">
                    <form method="POST" action="{{ route('surat.update', ['id' => $surat->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control-input" id="nama" name="nama" value="{{ $surat->nama }}" required>
                        </div>
                        <div class="form-group">
                            <label for="tipe_surat">Tipe Surat</label>
                            <input type="text" class="form-control-input" id="tipe_surat" name="tipe_surat" value="{{ $surat->tipe_surat }}" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control-input" id="status" name="status" required>
                                <option value="Dalam Proses" {{ $surat->status == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                                <option value="Selesai" {{ $surat->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control-input" id="keterangan" name="keterangan">{{ $surat->keterangan }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="file_path">File</label>
                            <input type="file" class="form-control-file" id="file_path" name="file_path" multiple>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>


        <div class="pdf-container">
            <object data="{{ Storage::url($surat->file_path) }}" type="application/pdf">
            <p>Tidak bisa menampilkan file PDF, silakan unduh untuk melihatnya: <a href="{{ Storage::url($surat->file_path) }}">Download PDF</a>.</p>
            </object>
        </div>
    </div>

</div>

</body>
</html>