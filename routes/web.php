<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Surat;


Route::get('/', function () {
    return view('welcome');
});





Route::middleware('auth')->group(function () {
    Route::get('/surat', [SuratController::class, 'index'])->name('surat.index');
});


Route::post('/register/success', [UserController::class, 'registerSuccess'])->name('register.success');




Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');




Route::get('/surat/create', [SuratController::class, 'create'])->name('surat.create');
Route::post('/surat', [SuratController::class, 'store'])->name('surat.store');
Route::get('/surat/{id}/edit', [SuratController::class, 'edit'])->name('surat.edit');

Route::put('/surat/{id}', [SuratController::class, 'update'])->name('surat.update');
Route::delete('/surat/{id}', [SuratController::class, 'destroy'])->name('surat.destroy');
Route::get('/surat/{id}', [SuratController::class, 'show'])->name('surat.show');
Route::get('/surat/{id}/download', [SuratController::class, 'download'])->name('surat.download');

Route::get('/surat/{id}/input-document', [SuratController::class, 'inputDocument'])->name('surat.inputDocument');

Route::put('/surat/{id}/update-status-input', [SuratController::class, 'updateStatusInput'])->name('surat.updateStatusInput');

Route::get('surat/{surat}/print', [SuratController::class, 'print'])->name('surat.print');



Route::patch('surat/{surat}/update-status', [SuratController::class, 'updateStatus'])->name('surat.updateStatus');

Route::middleware(['auth', 'role:verifikator'])->group(function () {
    // Rute-rute yang hanya dapat diakses oleh verifikator
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Rute-rute yang hanya dapat diakses oleh admin
});



Route::get('surat/{nik}/download-files', [SuratController::class, 'downloadFiles'])->name('surat.downloadFiles');

/*---------------------------------------------------------USER------------------------------------------------------------ */
Route::get('/users',  [UserController::class, 'index'])->name('user.index');
Route::get('/profile', 'UserController@profile')->name('profile');
Route::put('/profile/update', 'UserController@updateProfile')->name('profile.update');

Route::get('/profile/{user}', [UserController::class, 'showProfile'])->name('profile.show');
Route::get('/my-profile', [UserController::class, 'myProfile'])->name('profile.my');



















Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
