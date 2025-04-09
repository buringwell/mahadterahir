<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'isi',
        'kategori',
        'tanggal_publikasi',
        'penulis',
        'gambar',
        'status',
    ];

    protected $hidden = [
        'gambar', // Sembunyikan kolom 'gambar' saat model di-serialize (opsional)
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime', // Cast kolom 'tanggal_publikasi' ke tipe Carbon
        'status' => 'string', // Cast kolom 'status' ke tipe string
    ];
}
