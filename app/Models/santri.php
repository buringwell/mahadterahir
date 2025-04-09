<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class santri extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'no_induk_santri',
        'nis',
        'nama',
        'kamar',
        'kelas_sekolah',
        'alamat',
        'tanggal_lahir',
        'no_hp',
        'nama_ayah',
        'nama_ibu',
        'nama_wali',
        'status',
        'waktu_masuk',
        'waktu_keluar',
    ];

    // Define the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with SantriDetail
    public function santriDetail()
    {
        return $this->hasOne(SantriDetail::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }
    public function kamar()
    {
        return $this->belongsTo(kamar::class);
    }
    
    public function kelas()
    {
        return $this->belongsTo(kelas::class);
    }
    
}
