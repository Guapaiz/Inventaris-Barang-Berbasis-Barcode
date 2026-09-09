<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

protected $fillable = [
    'category_id', 'kode_barang', 'barcode', 'join_date', 'full_name', 'brand_name',
    'specification', 'fund_source', 'year', 'status', 'bagian_id', 'ruang_id',
    'lemari_id', 'rak_id', 'is_keluar',
];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class);
    }

    public function lemari(): BelongsTo
    {
        return $this->belongsTo(Lemari::class);
    }

    public function rak(): BelongsTo
    {
        return $this->belongsTo(Rak::class);
    }
    // Model Barang
    public function bagian()
    {
        return $this->belongsTo(Bagian::class);
    }    
    public function detailPeminjaman()
{
    return $this->hasMany(DetailPeminjaman::class);
}

}
