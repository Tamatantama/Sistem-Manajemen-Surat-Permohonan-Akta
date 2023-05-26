<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\File;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surats';
    protected $fillable = [
        'nama',
        'tipe_surat',
        'tanggal',
        'tanggal_pengambilan',
        'status',
        'keterangan',
        'file_path',
    ];

    public function penulis()
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }


    public function getStatusColorAttribute()
    {
        $today = Carbon::now();
        $tanggalPengambilan = Carbon::parse($this->tanggal_pengambilan);

        if ($today->isSameDay($tanggalPengambilan) || $today->copy()->addDay()->isSameDay($tanggalPengambilan)) {
            return 'yellow'; // Warna kuning untuk today atau sehari sebelumnya
        }

        if ($this->status == 'Terlambat') {
            return 'red'; // Warna merah untuk status terlambat
        }

        return ''; // Jika tidak ada warna khusus
    }




}

