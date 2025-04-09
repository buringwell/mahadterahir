<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class presensi extends Model
{
    use HasFactory;

    protected $table = 'presensis';

    protected $primaryKey = 'id';

    protected $fillable = [
        'santri_id',
        'tanggal',
        'status',
        'keterangan',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
