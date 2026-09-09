<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Menampilkan data kategori dengan jumlah barang per kategori
        $categories = Category::select('id', 'name')
            ->withCount(['barang as barang_count']) // alias biar Laravel yakin
            ->orderBy('barang_count', 'desc')
            ->get();


        // Tampilkan data ke view
        return view('dashboard.index', compact('categories'));
    }
}
