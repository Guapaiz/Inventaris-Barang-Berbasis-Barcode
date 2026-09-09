<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;


class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    public $timestamps = false;

    protected $fillable = [
        'nama_peminjam',
        'jenis_peminjam',
        'tujuan_peminjaman',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    public function detail()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    public function scanPengembalian(Request $request)
    {
        $data = $request->validate(['kode' => 'required|string']);

        $barang = Barang::where('kode_barang', $data['kode'])->first();

        if (!$barang) {
            return response()->json(['success' => false]);
        }

        $detail = DetailPeminjaman::with('peminjaman')
            ->where('barang_id', $barang->id)
            ->where('is_kembali', false)
            ->latest()
            ->first();

        if (!$detail) {
            return response()->json(['success' => false]);
        }

        return response()->json([
            'success' => true,
            'barang' => [
                'kode' => $barang->kode_barang,
                'nama' => $barang->full_name,
                'peminjam' => $detail->peminjaman->nama_peminjam ?? 'Tidak diketahui',
            ]
        ]);
    }
}
