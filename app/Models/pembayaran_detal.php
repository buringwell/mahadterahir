<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembayaran_detal extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'pembayaran_details';

    protected $fillable = [
        'pembayaran_id',
        'file_transaksi',
        'keterangan',
    ];

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }
}
