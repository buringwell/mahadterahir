<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembayaran extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'pembayarans';

    protected $fillable = [
        'santri_id',
        'jumlah',
        'tanggal',
        'bulan',
        'kode_transaksi',
        'status_pembayaran',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function pembayaran_detail()
    {
        return $this->hasOne(pembayaran_detal::class);
    }
}
