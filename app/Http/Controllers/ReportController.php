<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\Barang;
use App\Models\Ruang;
use App\Models\Bagian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Tampilkan form laporan (tanpa filter)
     */
    public function index(): View
    {
        $barang = []; // kosong di awal
        $ruangList = Ruang::orderBy('nama')->get();
        $bagianList = Bagian::orderBy('nama_bagian')->get();
        $kategoriList = \App\Models\Category::orderBy('name')->get();
        return view('report.index', compact('barang', 'ruangList', 'bagianList', 'kategoriList'));
    }

    /**
     * Proses filter berdasarkan rentang tanggal & filter lainnya
     */
    public function filter(Request $request)
    {
        $query = Barang::query();


        // Jika tanggal diisi, filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            try {
                $start = Carbon::createFromFormat('d-m-Y', $request->start_date)->startOfDay();
                $end = Carbon::createFromFormat('d-m-Y', $request->end_date)->endOfDay();
                $query->whereBetween('join_date', [$start, $end]);
            } catch (\Exception $e) {
                return back()->withErrors(['Tanggal tidak valid. Format harus dd-mm-yyyy.']);
            }
        }

        // Filter lainnya
        if ($request->filled('ruang_id')) {
            $query->where('ruang_id', $request->ruang_id);
        }
        if ($request->filled('bagian_id')) {
            $query->where('bagian_id', $request->bagian_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        if ($request->filled('brand_name')) {
            $query->where('brand_name', 'like', '%' . $request->brand_name . '%');
        }
        if ($request->filled('fund_source')) {
            $query->where('fund_source', 'like', '%' . $request->fund_source . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        $barang = $query->oldest('join_date')->get();

        $ruangList = Ruang::orderBy('nama')->get();
        $bagianList = Bagian::orderBy('nama_bagian')->get();
        $kategoriList = \App\Models\Category::orderBy('name')->get();
        return view('report.index', [
            'barang' => $barang,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'ruangList' => $ruangList,
            'bagianList' => $bagianList,
            'kategoriList' => $kategoriList,
        ]);
    }


    /**
     * Generate PDF dengan semua filter
     */
    public function print(string $start_date, string $end_date, Request $request)
    {
        $query = Barang::query();

        // Jika tanggal diisi dan valid (bukan '-')
        if ($start_date !== '-' && $end_date !== '-') {
            try {
                $start = Carbon::createFromFormat('d-m-Y', $start_date)->startOfDay();
                $end   = Carbon::createFromFormat('d-m-Y', $end_date)->endOfDay();
                $query->whereBetween('join_date', [$start, $end]);
            } catch (\Exception $e) {
                abort(400, 'Format tanggal tidak valid.');
            }
        }

        // Filter tambahan
        if ($request->filled('ruang_id')) {
            $query->where('ruang_id', $request->ruang_id);
        }
        if ($request->filled('bagian_id')) {
            $query->where('bagian_id', $request->bagian_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        if ($request->filled('brand_name')) {
            $query->where('brand_name', 'like', '%' . $request->brand_name . '%');
        }
        if ($request->filled('fund_source')) {
            $query->where('fund_source', 'like', '%' . $request->fund_source . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }


        $barang = $query->oldest('join_date')->get();

        $pdf = Pdf::loadView('report.print', [
            'barang'     => $barang,
            'start_date' => $start_date !== '-' ? $start_date : null,
            'end_date'   => $end_date !== '-' ? $end_date : null,
        ])->setPaper('a4', 'landscape');

        $filename = 'Laporan_Barang';
        if ($start_date !== '-' && $end_date !== '-') {
            $filename .= '_' . str_replace('-', '', $start_date) . '_sd_' . str_replace('-', '', $end_date);
        }
        $filename .= '.pdf';

        return $pdf->stream($filename);
    }
}
