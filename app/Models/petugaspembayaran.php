<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class petugaspembayaran extends Model
{
    use HasFactory;

    protected $table = 'petugas_pembayarans';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'pembayaran_id',
        'nama',
        'alamat',
        'no_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }
}
