<?php
// app/Models/Keterlambatan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keterlambatan extends Model
{
    use HasFactory;

    protected $table = 'keterlambatan';
    protected $primaryKey = 'id_telat';
    
    protected $fillable = [
        'id_siswa',
        'id_guru',
        'waktu_datang',
        'keterangan'
    ];

    protected $casts = [
        'waktu_datang' => 'datetime'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
}
