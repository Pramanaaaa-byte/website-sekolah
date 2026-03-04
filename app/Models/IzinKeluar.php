<?php
// app/Models/IzinKeluar.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinKeluar extends Model
{
    use HasFactory;

    protected $table = 'izin_keluar';
    protected $primaryKey = 'id_izin';
    
    protected $fillable = [
        'id_siswa',
        'id_guru',
        'alasan',
        'waktu_keluar',
        'waktu_kembali',
        'status'
    ];

    protected $casts = [
        'waktu_keluar' => 'datetime',
        'waktu_kembali' => 'datetime'
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
