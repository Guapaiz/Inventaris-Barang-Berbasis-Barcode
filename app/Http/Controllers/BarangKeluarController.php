<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangkeluar = BarangKeluar::latest()->paginate(10);
        return view('barangkeluar.index', compact('barangkeluar'));
    }

    public function create()
    {
        // Ambil barang yang statusnya 'Baik' (atau sesuai kebutuhan)
        $barang = Barang::where('status', 'Baik')->get();
        return view('barangkeluar.create', compact('barang'));
    }

    // BarangKeluarController.php

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'tujuan_ruangan' => 'nullable|string',
            'penerima' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        $barangKeluar = new BarangKeluar();
        $barangKeluar->full_name = $barang->full_name;
        $barangKeluar->brand_name = $barang->brand_name;
        $barangKeluar->specification = $barang->specification;
        $barangKeluar->fund_source = $barang->fund_source;
        $barangKeluar->year = $barang->year;
        $barangKeluar->join_date = $barang->join_date;
        $barangKeluar->kode_barang = $barang->kode_barang;
        $barangKeluar->status = $barang->status;
        $barangKeluar->bagian_id = $barang->bagian_id;
        $barangKeluar->ruang_id = $barang->ruang_id;

        // Tambahan dari form
        $barangKeluar->tanggal_keluar = now(); // gunakan tanggal hari ini atau bisa disesuaikan jika diinput
        $barangKeluar->tujuan_ruangan = $request->tujuan_ruangan;
        $barangKeluar->penerima = $request->penerima;
        $barangKeluar->keterangan = $request->keterangan;

        $barangKeluar->save();

        // Hapus dari tabel barang
        $barang->delete();

        return redirect()->route('barangkeluar.index')->with('success', 'Barang berhasil dikeluarkan');
    }


    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangKeluar->delete();

        return redirect()->route('barangkeluar.index')->with('success', 'Data barang keluar berhasil dihapus.');
    }
}
