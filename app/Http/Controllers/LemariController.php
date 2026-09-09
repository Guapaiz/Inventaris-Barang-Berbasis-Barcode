<?php

namespace App\Http\Controllers;

use App\Models\Lemari;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Ruang;
use App\Models\Barang;

class LemariController extends Controller
{

    public function create(Request $request)
    {
        $ruangId = $request->input('ruang_id');  // ambil dari query string
        $ruangList = Ruang::all();

        return view('lemari.create', [
            'ruangList' => $ruangList,
            'defaultRuangId' => $ruangId,  // lempar ke view
        ]);
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|unique:lemari,nama',
            'ruang_id' => 'required|exists:ruang,id',
        ]);

        Lemari::create([
            'nama' => $request->nama,
            'ruang_id' => $request->ruang_id,
        ]);

        return redirect()->route('ruang.show', $request->ruang_id)
            ->with('success', 'Lemari berhasil ditambahkan.');
    }


    public function show($id)
    {
        $lemari = Lemari::with('rak', 'ruang')->findOrFail($id); // Tambahkan 'ruang' juga biar tidak error saat akses $lemari->ruang->nama

        $ruangList = Ruang::all(); // Jika masih dibutuhkan

        $barang = Barang::where('lemari_id', $lemari->id)->paginate(10);


        return view('lemari.show', compact('lemari', 'ruangList', 'barang'));
    }

    public function edit($id)
    {
        // Ambil data lemari berdasarkan ID
        $lemari = Lemari::findOrFail($id);

        // Ambil daftar ruang yang ada
        $ruangList = Ruang::all();  // Ambil semua data ruang

        // Kembalikan ke view edit lemari dengan membawa data lemari dan daftar ruang
        return view('lemari.edit', compact('lemari', 'ruangList'));
    }

    public function update(Request $request, $id)
    {
        $lemari = Lemari::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:lemari,nama,' . $lemari->id,
            'ruang_id' => 'required|exists:ruang,id',
        ]);

        $lemari->update([
            'nama' => $request->input('nama'),
            'ruang_id' => $request->input('ruang_id'),
        ]);

        return redirect()->route('ruang.show', $lemari->ruang_id)
            ->with('success', 'Lemari berhasil diperbarui!');
    }



    public function destroy(string $id): RedirectResponse
    {
        $lemari = Lemari::findOrFail($id);
        $ruangId = $lemari->ruang_id; // Ambil ID ruang dari lemari sebelum dihapus
        $lemari->delete();

        return redirect()->route('ruang.show', $ruangId)->with('success', 'Lemari berhasil dihapus.');
    }


    public function getByRuang(Request $request)
    {
        $lemaris = Lemari::where('ruang_id', $request->ruang_id)->get(['id', 'nama']);
        return response()->json($lemaris);
    }
}
