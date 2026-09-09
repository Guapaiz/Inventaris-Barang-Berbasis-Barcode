<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lemari extends Model
{
    protected $table = 'lemari';
    protected $fillable = ['nama', 'ruang_id'];

    public function rak(): HasMany
    {
        return $this->hasMany(Rak::class, 'lemari_id');
    }

    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'lemari_id');
    }

    public function ruang(): BelongsTo
    {
        return $this->belongsTo(Ruang::class, 'ruang_id');
    }
}

