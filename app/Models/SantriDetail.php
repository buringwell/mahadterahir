<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SantriDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'santri_id';

    protected $fillable = [
        'santri_id',
        'tanggal_daftar',
        'file_foto',
        'daftar_ulang',
        'status',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }
}
