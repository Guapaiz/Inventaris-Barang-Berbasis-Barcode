<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use App\Models\Lemari;
use App\Models\Barang;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    public function index()
    {
        $ruang = Ruang::orderBy('nama')->paginate(10);
        return view('ruang.index', compact('ruang'));
    }

    public function create()
    {
        return view('ruang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:ruang,nama',
            'detail' => 'nullable|string',
        ]);

        Ruang::create([
            'nama' => $request->nama,
            'detail' => $request->detail,
        ]);

        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil ditambahkan.');
    }

    public function show(Ruang $ruang)
    {
        // Ambil daftar lemari di ruang
        $lemariList = Lemari::where('ruang_id', $ruang->id)->get();

        // Ambil barang di ruang tersebut yang tidak berada di dalam lemari
        $barang = Barang::where('ruang_id', $ruang->id)
            ->whereNull('lemari_id')
            ->paginate(10);

        return view('ruang.show', compact('ruang', 'lemariList', 'barang'));
    }

    public function edit(Ruang $ruang)
    {
        return view('ruang.edit', compact('ruang'));
    }

    public function update(Request $request, Ruang $ruang)
    {
        $request->validate([
            'nama' => 'required|string|unique:ruang,nama,' . $ruang->id,
            'detail' => 'nullable|string',
        ]);

        $ruang->update([
            'nama' => $request->nama,
            'detail' => $request->detail,
        ]);

       return redirect()->route('ruang.show', $ruang)->with('success', 'Ruang berhasil diperbarui.');
    }


    public function destroy(Ruang $ruang)
    {
        $ruang->delete();
        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil dihapus.');
    }
}
