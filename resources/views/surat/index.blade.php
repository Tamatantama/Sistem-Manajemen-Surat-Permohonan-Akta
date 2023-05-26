<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
    <script src="https://kit.fontawesome.com/ee61ad490e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    

    
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">

    <title>Manajemen Surat</title>
</head>
<body>
<div class="base">
    <!-- Header -->
    <div class="page-padding"> 
        
        <header>
            <div class="header">
                <a href="{{ route('surat.index') }}"><img class="header-logo" src="{{ asset('/images/logo.png') }}" alt=""></a>
                <div class="header-nav">
                    <a class="active" href="{{ route('surat.index') }}" id="home">Beranda</a>
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

    </div>


    

   
    <div class="container-hor">
    <!----------------------Create New------------------------------------------>
        <div class="create-new">
            <a href="{{ route('surat.create', ['id' => $surat->first()->id]) }}" class="btn btn-primary">Buat Baru</a>

        </div>
        

        <!----------------------Search Bar------------------------------------------>

        <div class="search-container">
            <input id="search-input" type="text" placeholder="Cari surat..." />
            <button id="search-button" type="button"><i class="fas fa-search"></i></button>
            <button id="clear-button" type="button"><i class="fas fa-times"></i></button>
        </div>

    </div>
            <p id="search-query-text">{{ request('search') ? 'Result for "' . request('search') . '"' : '' }}</p>

        <!-- Table code -->

        <script>
            // Inisialisasi input pencarian
            const searchInput = new Cleave('#search-input', {
                delimiter: '',
                numericOnly: false
            });

            // Tombol pencarian
            const searchButton = document.getElementById('search-button');
            searchButton.addEventListener('click', () => {
                performSearch();
            });

            // Tombol clear
            const clearButton = document.getElementById('clear-button');
            clearButton.addEventListener('click', () => {
                clearSearch();
            });

            // Handle tombol Enter pada input pencarian
            const searchInputWrapper = document.getElementById('search-input');
            searchInputWrapper.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    performSearch();
                }
            });

            // Perform search function
            function performSearch() {
                const keyword = searchInput.getRawValue();
                const searchQueryText = document.getElementById('search-query-text');
                searchQueryText.textContent = `Result for "${keyword}"`;
                searchQueryText.style.display = 'block';
                window.location.href = `{{ route('surat.index') }}?search=${keyword}`;
            }

            // Clear search function
            function clearSearch() {
                searchInput.setRawValue('');
                const searchQueryText = document.getElementById('search-query-text');
                searchQueryText.textContent = '';
                searchQueryText.style.display = 'none';
                window.location.href = `{{ route('surat.index') }}`;
            }
        </script>


        @php
            $perPage = 10;
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $startIndex = ($currentPage - 1) * $perPage;
            $endIndex = $startIndex + $perPage;
        @endphp

    <table>
        <thead>
            <tr>
                <th></th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tipe Surat</th>
                <th>Tanggal</th>
                <th>Tanggal Pengambilan</th>
                <th>Status</th>
                <th>Keterangan</th>
        
                <!--<th>File Path</th>-->
                <th>Penulis</th>
                <th>Penginput</th>
                <th>Diverifikasi Oleh</th>
                <th>Lihat</th>
                <th>Edit</th>
                <th>Input Dokumen</th>
                <th>Hapus</th>
            </tr>
        </thead>
            <tbody>
                @foreach($surat-> slice($startIndex, $endIndex) as $surat)
                @if(is_object($surat))
                    @php
                        $dueDate = date('Y-m-d', strtotime('+1 day', strtotime($surat->tanggal_pengambilan)));
                        $isLate = $dueDate == date('Y-m-d') || $dueDate < date('Y-m-d');
                    @endphp 
                <tr>

                <td>
                    {{-- Check if today is a day before or equal to tanggal_pengambilan --}}
                    {{-- Check if today is a day before or equal to tanggal_pengambilan --}}
                    @if($surat->status == 'Selesai')
                    <i class="fas fa-check-circle text-success"></i>
                    @elseif (Carbon\Carbon::today()->lte(Carbon\Carbon::parse($surat->tanggal_pengambilan)->subDay()))
                       
                        <i class="fas fa-exclamation-triangle text-warning alert-icon"></i>
                    @elseif ($surat->status == 'Terlambat')
                        
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                    @else
                        
                    @endif
                </td>

                    <td>{{ $surat->NIK }}</td>
                    <td>{{ $surat->nama }}</td>
                    <td>{{ $surat->tipe_surat }}</td>
                    <td>{{ $surat->tanggal }}</td>
                    <td>{!! $isLate && $surat->status != 'Selesai' ? '<span class="late">' . $surat->tanggal_pengambilan . ' (Terlambat)</span>' : $surat->tanggal_pengambilan !!}</td>
<td>{!! $isLate && $surat->status != 'Selesai' ? '<span class="late">' . $surat->status . '</span>' : ($surat->status == 'Selesai' ? '<span class="selesai">' . $surat->status . '</span>' : $surat->status) !!}</td>
 <td>{{ $surat->keterangan }}</td>
                
                    <!----<td>{{ $surat->file_path }}</td>-->
                    <td>{{ $surat->penulis->name ?? '-' }}</td>
                    <td>{{ $surat->inputted_by ?? '-'}}</td>
                    <td>{{ $surat->verified_by ?? '-'}}</td>


                    <td><a href="{{ route('surat.show', ['id' => $surat->id]) }}"class="btn btn-primary">Lihat</a></td>
                    <td>
                        <div class="card-footer">
                            <a href="{{ route('surat.edit', $surat->id) }}" class="btn btn-primary">Edit</a>
                        </div>
                    </td>
                    <td>
                        <div class="card-footer">
                            <a href="{{ route('surat.inputDocument', $surat->id) }}" class="btn btn-primary">Input</a>
                        </div>
                    </td>
                    
                    <td>
                        <form method="POST" action="{{ route('surat.destroy', ['id' => $surat->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary delete-btn" data-id="{{ $surat->id }}">Hapus</button>
                        </form>
                    </td>
                      

                    <script>
                        // Get all delete buttons
                        const deleteButtons = document.querySelectorAll('.delete-btn');

                        // Add event listener to each delete button
                        deleteButtons.forEach(button => {
                            button.addEventListener('click', event => {
                                event.preventDefault();

                                // Get the ID of the surat
                                const suratId = button.getAttribute('data-id');

                                // Show pop-up confirmation
                                Swal.fire({
                                    title: 'Apakah Anda yakin ingin menghapus surat ini?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, hapus!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // If user clicks "OK", submit the form
                                        const form = document.querySelector(`form[action="${button.parentNode.getAttribute('action')}"]`);
                                        form.submit();

                                        // Show success message
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: 'Surat berhasil dihapus.',
                                            icon: 'success',
                                            position: 'center',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                    }
                                });
                            });
                        });
                    </script>



                </tr>
                @endif
                @endforeach
        </tbody>
    </table>
    <!-----------------------------------------------Tabel Tipe--------------------------------------------------------------------------------->
    <table class="table">
        <thead>
            <tr>
                <th>Tipe Surat</th>
                <th>Jumlah Surat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suratTypes as $type)
                <tr>
                    <td>{{ $type->tipe_surat }}</td>
                    <td>{{ $type->count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-----------------------------------------------Tabel Status--------------------------------------------------------------------------------->
    <table class="table">
        <thead>
            <tr>
                <th>Status</th>
                <th>Jumlah Surat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suratStatus as $status)
                <tr>
                    <td>{{ $status->status }}</td>
                    <td>{{ $status->count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>




    <div class="pagination">
        @if ($currentPage > 1)
            <a href="?page={{ $currentPage - 1 }}" class="pagination-btn">Previous</a>
        @endif

        @for ($i = 1; $i <= ceil($surat->count() / $perPage); $i++)
            <a href="?page={{ $i }}" class="{{ $i == $currentPage ? 'active' : '' }}">{{ $i }}</a>
        @endfor

        @if ($currentPage < ceil($surat->count() / $perPage))
            <a href="?page={{ $currentPage + 1 }}" class="pagination-btn">Next</a>
        @endif
    </div>







   
</div>

    <footer class="footer">
        <div class="container-footer">
            <div class="row">
                <div class="col-md-6">
                    <p>Copyright &copy; 2023 Dinas Kependudukan dan Pencatatan Sipil Kota Pekalongan. All Rights Reserved.</p>
                </div>
                <div class="col-md-6">
                    <ul class="footer-nav">
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat dan Ketentuan</a></li>
                        <li><a href="#">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>



</body>
</html>
