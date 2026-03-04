<?php
// app/Models/Piket.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piket extends Model
{
    use HasFactory;

    protected $table = 'piket';
    protected $primaryKey = 'id_piket';
    
    protected $fillable = [
        'id_guru',
        'tanggal'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
}
