<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Bagian;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DownloadController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter dari request
        $search = $request->input('search');
        $ruang_id = $request->input('ruang_id');
        $bagian_id = $request->input('bagian_id');
        $status = $request->input('status');
        $year = $request->input('year');
        $brand_name = $request->input('brand_name');
        $fund_source = $request->input('fund_source');

        // Query dengan filter
        $query = Barang::select('id', 'full_name', 'kode_barang', 'barcode', 'specification', 'brand_name', 'fund_source', 'year', 'status', 'bagian_id', 'ruang_id')
            ->with(['bagian', 'ruang']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('brand_name', 'like', "%{$search}%")
                    ->orWhere('specification', 'like', "%{$search}%")
                    ->orWhere('kode_barang', 'like', "%{$search}%");
            });
        }

        if ($ruang_id) {
            $query->where('ruang_id', $ruang_id);
        }

        if ($bagian_id) {
            $query->where('bagian_id', $bagian_id);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($year) {
            $query->where('year', $year);
        }

        if ($brand_name) {
            $query->where('brand_name', 'like', "%{$brand_name}%");
        }

        if ($fund_source) {
            $query->where('fund_source', 'like', "%{$fund_source}%");
        }

        // Asumsi hanya barang belum keluar yang di-download (optional)
        $query->where('is_keluar', false);

        // Ambil data dengan paginasi
        $barang = $query->orderBy('created_at', 'asc')->paginate(10)->withQueryString();


        // Data untuk filter dropdown
        $ruangList = Ruang::all();
        $bagianList = Bagian::all();

        // Total barang hasil filter
        $totalBarang = $query->count();

        return view('download.index', compact('barang', 'ruangList', 'bagianList', 'totalBarang'));
    }

    public function download($id)
    {
        $barang = Barang::findOrFail($id);

        if (!$barang->barcode) {
            abort(404, 'Barcode tidak tersedia');
        }

        $imageData = base64_decode($barang->barcode);
        $fileName = $barang->kode_barang . '.png';

        return Response::make($imageData, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
