<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    protected $table = 'rak';  // Tentukan nama tabel dengan benar

    protected $fillable = ['lemari_id', 'nama'];

    public function lemari()
    {
        return $this->belongsTo(Lemari::class);
    }
    public function barang()
{
    return $this->hasMany(\App\Models\Barang::class);
}

}



