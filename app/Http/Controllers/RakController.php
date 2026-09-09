<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use App\Models\Lemari;
use App\Models\Barang;
use Illuminate\Http\Request;

class RakController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $rak = Rak::with('lemari')
            ->where('nama', 'like', '%' . $search . '%')
            ->latest()
            ->paginate(10);

        return view('rak.index', compact('rak'));
    }

    public function create(Request $request)
    {
        $lemariId = $request->lemari_id;

        if (!$lemariId || !Lemari::find($lemariId)) {
            return redirect()->route('raks.index')->with('error', 'Lemari tidak ditemukan.');
        }

        return view('rak.create', compact('lemariId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lemari_id' => 'required|exists:lemari,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $lemari = Lemari::findOrFail($request->lemari_id);
        $jumlah = $request->jumlah;

        // Hitung rak yang sudah ada di lemari ini
        $rakCountInLemari = Rak::where('lemari_id', $lemari->id)->count();

        $newRak = [];
        for ($i = 1; $i <= $jumlah; $i++) {
            $namaRak = 'Rak ' . $lemari->nama . '-' . ($rakCountInLemari + $i);

            $newRak[] = [
                'lemari_id' => $lemari->id,
                'nama' => $namaRak,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Rak::insert($newRak);

        return redirect()->route('lemari.show', $lemari->id)
            ->with('success', 'Rak berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rak = Rak::findOrFail($id);
        $lemariList = Lemari::orderBy('nama')->get();
        return view('rak.edit', compact('rak', 'lemariList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|unique:rak,nama,' . $id,
        ]);

        $rak = Rak::findOrFail($id);
        $rak->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('lemari.show', $rak->lemari_id)
            ->with('success', 'Rak berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $rak = Rak::findOrFail($id);
        $lemariId = $rak->lemari_id; // Ambil ID lemarinya dulu
        $rak->delete();

        return redirect()->route('lemari.show', $lemariId)->with('success', 'Rak berhasil dihapus.');
    }


    public function getRakByRuangDanLemari(Request $request)
    {
        $ruangNama = $request->ruang_id;
        $lemariId = $request->lemari_id;

        $ruang = \App\Models\Ruang::where('nama', $ruangNama)->first();

        if ($ruang) {
            $rak = Rak::whereHas('lemari', function ($query) use ($ruang) {
                $query->where('ruang_id', $ruang->id);
            })
                ->where('lemari_id', $lemariId)
                ->get();

            return response()->json($rak);
        } else {
            // Jika ruang tidak ditemukan, kembalikan array kosong
            return response()->json([]);
        }
    }
    public function show($id)
    {

        $rak = Rak::with('lemari', 'barang')->findOrFail($id);
        return view('rak.show', compact('rak'));
    }


    public function getByLemari(Request $request)
    {
        $raks = Rak::where('lemari_id', $request->lemari_id)->get(['id', 'nama']);
        return response()->json($raks);
    }
    
}
