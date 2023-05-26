<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <title>Input Data Berkas</title>
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
                    <h5 class="card-title">{{ $surat->nama }}</h5>
                    <p class="card-text">{{ $surat->NIK}}</p>
                    <p class="card-text">{{ $surat->tipe_surat }}</p>
                    <p class="card-text">Tanggal: {{ $surat->tanggal }}</p>
                    <p class="card-text">Tanggal Pengambilan: {{ $surat->tanggal_pengambilan }}</p>
                    <p class="card-text">Status: {{ $surat->status }}</p>
                    <p class="card-text">Keterangan: {{ $surat->keterangan }}</p>
                    <a>
                        <form method="POST" action="{{ route('surat.update', ['id' => $surat->id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="file_path">File</label>
                                 <input type="file" name="file_path[]" multiple>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </a>
                    <a>
                        <form action="{{ route('surat.updateStatusInput', $surat->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            

                            @if ($surat->status == 'Dokumen Lengkap')
                                <button type="button" class="btn btn-secondary" disabled>Dokumen Lengkap</button>
                            @else
                                <button type="submit" class="btn btn-success" id="input-document-btn">Ubah Status Menjadi Dokumen Lengkap</button>
                            @endif
                        </form>
                    </a>
                </div>
            </div>
        </div>

                

        <script>
                    const ubahStatusBtn = document.getElementById('input-document-btn');
                    const form = document.querySelector('form');
                    
                    form.addEventListener('submit', (event) => {
                        event.preventDefault();
                        const url = event.target.action;
                        const formData = new FormData(event.target);
                        
                        fetch(url, {
                            method: 'PATCH',
                            body: formData
                        })
                        .then(response => {
                            if (response.ok) {
                                ubahStatusBtn.classList.remove('btn-success');
                                ubahStatusBtn.classList.add('btn-secondary');
                                ubahStatusBtn.disabled = true;
                                
                                const statusBadge = document.querySelector('.badge');
                                if (statusBadge) {
                                    statusBadge.classList.remove('badge-primary');
                                    statusBadge.classList.add('badge-success');
                                    statusBadge.textContent = 'Selesai';
                                }
                                
                                const verifiedText = document.createElement('p');
                                verifiedText.classList.add('card-text');
                                verifiedText.textContent = `Verified by ${response.user.name}`;
                                const cardBody = document.querySelector('.card-body');
                                cardBody.appendChild(verifiedText);
                                
                                setTimeout(() => {
                                    ubahStatusBtn.classList.add('fade');
                                    ubahStatusBtn.classList.add('disabled');
                                }, 2000);
                            }
                        })
                        .catch(error => console.error(error));
                    });
                </script>


        <div class="pdf-container">
            <object data="{{ Storage::url($surat->file_path) }}" type="application/pdf">
            <p>Tidak bisa menampilkan file PDF, silakan unduh untuk melihatnya: <a href="{{ Storage::url($surat->file_path) }}">Download PDF</a>.</p>
            </object>
        </div>
    </div>

    
</div>

</body>
</html>