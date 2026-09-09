<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';

    protected $fillable = [
        'full_name',
        'brand_name',
        'specification',
        'fund_source',
        'year',
        'join_date',
        'kode_barang',
        'status',
        'bagian_id',
        'ruang_id',

        'tanggal_keluar',
        'tujuan_ruangan',
        'penerima',
        'keterangan',
    ];

    public function bagian()
    {
        return $this->belongsTo(Bagian::class, 'bagian_id');
    }
    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'ruang_id');
    }
}
