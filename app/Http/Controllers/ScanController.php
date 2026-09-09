<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        return view('scan.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'kode' => 'required|string',
        ]);

        $barang = Barang::with(['bagian', 'ruang', 'lemari', 'rak'])
            ->where('kode_barang', $request->kode)
            ->first();

        if ($barang) {
            return response()->json([
                'success' => true,
                'barang' => [
                    'id'          => $barang->id,  // Menambahkan id agar bisa digunakan untuk routing edit/hapus
                    'nama'        => $barang->full_name,
                    'spesifikasi' => $barang->specification,
                    'kode'        => $barang->kode_barang,
                    'bagian'      => optional($barang->bagian)->nama_bagian,
                    'bagian_id'   => $barang->bagian_id,
                    'ruang'       => optional($barang->ruang)->nama,
                    'ruang_id'    => $barang->ruang_id,
                    'lemari'      => optional($barang->lemari)->nama,
                    'rak'         => optional($barang->rak)->nama,
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan.'
            ]);
        }
    }
}
