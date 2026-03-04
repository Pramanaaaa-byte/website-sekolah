<?php
// app/Models/Guru.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $primaryKey = 'id_guru';
    
    protected $fillable = [
        'nama',
        'jabatan'
    ];

    public function piket()
    {
        return $this->hasMany(Piket::class, 'id_guru');
    }

    public function izinKeluar()
    {
        return $this->hasMany(IzinKeluar::class, 'id_guru');
    }

    public function keterlambatan()
    {
        return $this->hasMany(Keterlambatan::class, 'id_guru');
    }
}
