<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use Illuminate\Http\Request;

class BagianController extends Controller
{
    public function index()
    {
        $bagian = Bagian::orderBy('nama_bagian')->paginate(10);
        return view('bagian.index', compact('bagian'));
    }

    public function create()
    {
        return view('bagian.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|unique:bagian,nama_bagian']);
        Bagian::create(['nama_bagian' => $request->nama]);
        return redirect()->route('bagian.index')->with('success', 'Bagian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bagian = Bagian::findOrFail($id);
        return view('bagian.edit', compact('bagian'));
    }

    public function update(Request $request, Bagian $bagian)
    {
        $request->validate([
            'nama_bagian' => 'required|string|unique:bagian,nama_bagian,' . $bagian->id
        ]);

        $bagian->update(['nama_bagian' => $request->nama_bagian]);

        return redirect()->route('bagian.index')->with('success', 'Bagian berhasil diperbarui.');
    }

    public function destroy(Bagian $bagian)
    {
        $bagian->delete();
        return redirect()->route('bagian.index')->with('success', 'Bagian berhasil dihapus.');
    }
    
}
