<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ustad extends Model
{
    use HasFactory;

    protected $table = 'ustadzs';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'JK',
        'alamat',
        'No_HP',
        'mata_pelajaran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
