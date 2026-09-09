<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang benar
    protected $table = 'ruang';
    protected $fillable = ['nama', 'detail'];


    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    public function lemari()
    {
        return $this->hasMany(Lemari::class);
    }
}
