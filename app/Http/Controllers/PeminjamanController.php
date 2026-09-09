<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Category;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    // Form peminjaman
    public function create(Request $request)
    {
        // Ambil semua kategori untuk dropdown
        $kategoriList = Category::all();

        // Query barang
        $barangQuery = Barang::with('category')
            ->where('status', 'Baik')
            ->where('is_keluar', false)
            ->whereDoesntHave('detailPeminjaman', function ($q) {
                $q->where('is_kembali', false);
            });

        // Jika ada filter kategori
        if ($request->filled('category_id')) {
            $barangQuery->where('category_id', $request->category_id);
        }

        // Ambil semua barang
        $barang = $barangQuery->get();

        // Hitung total barang
        $totalBarang = $barang->count();

        return view('peminjaman.create', compact('barang', 'kategoriList', 'totalBarang'));
    }



    // Simpan data peminjaman
    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'jenis_peminjam' => 'required|in:Guru,Siswa,Umum',
            'tujuan_peminjaman' => 'required|string|max:255',
            'barang_ids' => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $peminjaman = Peminjaman::create([
                'nama_peminjam' => $request->nama_peminjam,
                'jenis_peminjam' => $request->jenis_peminjam,
                'tujuan_peminjaman' => $request->tujuan_peminjaman,
                'tanggal_pinjam' => now(),
            ]);

            foreach ($request->barang_ids as $barangId) {
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'barang_id' => $barangId,
                    'is_kembali' => false,
                ]);
            }
        });
        return redirect()->route('peminjaman.index', ['tab' => 'peminjaman'])->with('success', 'Peminjaman berhasil disimpan.');
    }

    // Daftar peminjaman
    public function index(Request $request)
    {
        // Ambil tab aktif dari request (default ke 'barang')
        $activeTab = $request->get('tab', 'barang');

        // Ambil semua kategori untuk dropdown filter
        $kategoriList = Category::all();

        // Ambil data peminjaman (dengan pagination khusus)
        $peminjaman = Peminjaman::with('detail.barang')
            ->orderBy('tanggal_pinjam', 'desc')
            ->paginate(10, ['*'], 'peminjaman_page') // gunakan nama page khusus
            ->appends($request->except('peminjaman_page'))
            ->appends(['tab' => 'peminjaman']);

        // Query barang
        $barangQuery = Barang::with('category')
            ->where('status', 'Baik')
            ->where('is_keluar', false)
            ->whereDoesntHave('detailPeminjaman', function ($q) {
                $q->where('is_kembali', false);
            });

        // Filter kategori hanya jika sedang di tab 'barang'
        if ($activeTab === 'barang' && $request->filled('category_id')) {
            $barangQuery->where('category_id', $request->category_id);
        }

        // Ambil data barang (dengan pagination khusus)
        $barangList = $barangQuery
            ->paginate(20, ['*'], 'barang_page') // gunakan nama page khusus
            ->appends($request->except('barang_page'))
            ->appends(['tab' => 'barang']);

        return view('peminjaman.index', compact(
            'activeTab',
            'kategoriList',
            'peminjaman',
            'barangList'
        ));
    }


    // Form pengembalian
    public function pengembalianForm()
    {
        return view('peminjaman.pengembalian');
    }

    // Proses pengembalian
    public function pengembalianSubmit(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string',
        ]);

        $barang = Barang::where('kode_barang', $request->kode_barang)->first();

        if (!$barang) {
            return back()->with('error', 'Barang tidak ditemukan.');
        }

        $detail = DetailPeminjaman::where('barang_id', $barang->id)
            ->where('is_kembali', false)
            ->latest()->first();

        if (!$detail) {
            return back()->with('error', 'Barang ini tidak sedang dipinjam.');
        }

        $detail->update(['is_kembali' => true]);

        // Jika semua barang dalam satu peminjaman sudah dikembalikan, update status
        $peminjaman = $detail->peminjaman;
        $semuaKembali = $peminjaman->detail()->where('is_kembali', false)->count() === 0;
        if ($semuaKembali) {
            $peminjaman->update([
                'status' => 'Dikembalikan',
                'tanggal_kembali' => now()->toDateString(),
            ]);
        }

        return back()->with('success', 'Barang berhasil dikembalikan.');
    }
    public function destroy($id)
    {
        $peminjaman = Peminjaman::with('detail')->findOrFail($id);

        $belumKembali = $peminjaman->detail->where('is_kembali', false)->count();
        if ($belumKembali > 0) {
            return back()->with('error', 'Tidak bisa menghapus. Masih ada barang yang belum dikembalikan.');
        }

        foreach ($peminjaman->detail as $detail) {
            $detail->delete();
        }

        $peminjaman->delete();

        return back()->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
