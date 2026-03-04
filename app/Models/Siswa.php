<?php
// app/Models/Siswa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    
    protected $fillable = [
        'nis',
        'nama',
        'kelas'
    ];

    public function izinKeluar()
    {
        return $this->hasMany(IzinKeluar::class, 'id_siswa');
    }

    public function keterlambatan()
    {
        return $this->hasMany(Keterlambatan::class, 'id_siswa');
    }
}
