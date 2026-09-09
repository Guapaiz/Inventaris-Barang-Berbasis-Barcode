<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use App\Models\Bagian;
use App\Models\Barang;

class ChartController extends Controller
{
    public function index()
    {
        // --- Per Bagian
        $bagians = Bagian::all();
        $labelsBagian = [];
        $dataBagian = [];
        foreach ($bagians as $bagian) {
            $labelsBagian[] = $bagian->nama_bagian;
            $dataBagian[] = Barang::where('bagian_id', $bagian->id)->count();
        }

        // --- Per Ruang
        $ruangs = Ruang::all();
        $labelsRuang = [];
        $dataRuang = [];
        foreach ($ruangs as $ruang) {
            $labelsRuang[] = $ruang->nama;
            $dataRuang[] = Barang::where('ruang_id', $ruang->id)->count();
        }

        // --- Per Sumber Dana
        $fundSources = Barang::select('fund_source')
            ->whereNotNull('fund_source')
            ->groupBy('fund_source')
            ->selectRaw('fund_source, COUNT(*) as total')
            ->pluck('total', 'fund_source');

        $labelsFundSource = $fundSources->keys();
        $dataFundSource = $fundSources->values();

        // --- Per Tahun 
        $labelsTahun = Barang::select('year')
            ->whereNotNull('year')
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('year');

        $dataTahun = [];
        foreach ($labelsTahun as $tahun) {
            $dataTahun[] = Barang::where('year', $tahun)->count();
        }

        // --- Per Status
        $labelsStatus = Barang::whereNotNull('status')
            ->select('status')
            ->distinct()
            ->pluck('status');

        $dataStatus = [];
        foreach ($labelsStatus as $status) {
            $dataStatus[] = Barang::where('status', $status)->count();
        }

        return view('chart.index', compact(
            'labelsBagian',
            'dataBagian',
            'labelsRuang',
            'dataRuang',
            'labelsFundSource',
            'dataFundSource',
            'labelsTahun',
            'dataTahun',
            'labelsStatus',
            'dataStatus'
        ));
    }
}
