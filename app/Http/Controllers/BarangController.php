<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Barang;
use App\Models\Bagian;
use App\Models\Lemari;
use App\Models\Ruang;
use App\Models\Rak;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager; // JANGAN DIHAPUS
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Response;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with(['bagian', 'ruang'])
            ->where('is_keluar', false);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                    ->orWhere('specification', 'like', "%$search%")
                    ->orWhere('kode_barang', 'like', "%$search%");
            });
        }

        if ($request->filled('brand_name')) {
            $query->where('brand_name', 'like', '%' . $request->brand_name . '%');
        }
        if ($request->filled('ruang_id')) {
            $query->where('ruang_id', $request->ruang_id);
        }
        if ($request->filled('fund_source')) {
            $query->where('fund_source', 'like', '%' . $request->fund_source . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        // Hapus kondisi default status 'Baik'

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        if ($request->filled('bagian_id')) {
            $query->where('bagian_id', $request->bagian_id);
        }

        $totalBarang = $query->count();
        $barang = $query->oldest()->paginate(10)->appends($request->query());

        $ruangList = Ruang::orderBy('nama')->get();
        $bagianList = Bagian::orderBy('nama_bagian')->get();

        return view('barang.index', compact('barang', 'ruangList', 'bagianList', 'totalBarang'));
    }


    public function create()
    {
        $categories = Category::all();
        $lemaris = Lemari::orderBy('nama')->pluck('nama', 'id');
        $ruangs = Ruang::orderBy('nama')->pluck('nama', 'id');
        $bagians = Bagian::orderBy('nama_bagian')->pluck('nama_bagian', 'id');

        return view('barang.create', compact('categories', 'lemaris', 'ruangs', 'bagians'));
    }

    public function store(Request $request)
{
    $request->validate([
        'category'      => 'required|exists:categories,id',
        'join_date'     => 'required|date_format:d-m-Y',
        'full_name'     => 'required|string|max:255',
        'brand_name'    => 'required|string|max:255',
        'specification' => 'required|string',
        'fund_source'   => 'required|string|max:255',
        'year'          => 'required|integer|min:1900|max:' . date('Y'),
        'status'        => 'required|in:Baik,Rusak',
        'bagian_id'     => 'required|exists:bagian,id',
        'ruang_id'      => 'required|exists:ruang,id',
        'lemari_id'     => 'nullable|exists:lemari,id',
        'rak_id'        => 'nullable|exists:rak,id',
        'jumlah_barang' => 'required|integer|min:1|max:100',
    ]);

    $jumlahBarang = $request->input('jumlah_barang', 1);
    $join_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->input('join_date'))->format('Y-m-d');
    $category = Category::findOrFail($request->input('category'));

    // Ambil kode terakhir dari barang dan barang keluar
    $latestKode1 = Barang::where('kode_barang', 'like', $category->code_prefix . '%')
        ->orderBy('kode_barang', 'desc')
        ->value('kode_barang');

    $latestKode2 = BarangKeluar::where('kode_barang', 'like', $category->code_prefix . '%')
        ->orderBy('kode_barang', 'desc')
        ->value('kode_barang');

    $lastNumber = max(
        $latestKode1 ? intval(substr($latestKode1, strlen($category->code_prefix))) : 0,
        $latestKode2 ? intval(substr($latestKode2, strlen($category->code_prefix))) : 0
    );

    $generator = new BarcodeGeneratorPNG();
    $imageManager = new ImageManager(new GdDriver());

    for ($i = 1; $i <= $jumlahBarang; $i++) {
        $lastNumber++;
        $kode_barang = $category->code_prefix . str_pad($lastNumber, 4, '0', STR_PAD_LEFT);

        // Generate barcode PNG (raw)
        $barcodeRaw = $generator->getBarcode($kode_barang, $generator::TYPE_CODE_128, 4, 80);
        $barcodeImage = $imageManager->read($barcodeRaw)->resize(320, 85);

        // Buat canvas putih
        $canvas = $imageManager->create($barcodeImage->width() + 40, $barcodeImage->height() + 60)->fill('#ffffff');
        $canvas->place($barcodeImage, 'center');

        // Tambahkan teks di bawah barcode
        $canvas->text($kode_barang, $canvas->width() / 2, $canvas->height() - 10, function ($font) {
            $font->file(public_path('fonts/nunito/Nunito-Black.ttf'));
            $font->size(14);
            $font->color('#000000');
            $font->align('center');
            $font->valign('bottom');
        });

        // Encode jadi base64 PNG
        $barcodeBase64 = base64_encode((string) $canvas->encode(new PngEncoder()));

        // Simpan ke database
        Barang::create([
            'category_id'    => $category->id,
            'join_date'      => $join_date,
            'full_name'      => $request->input('full_name'),
            'brand_name'     => $request->input('brand_name'),
            'specification'  => $request->input('specification'),
            'fund_source'    => $request->input('fund_source'),
            'year'           => $request->input('year'),
            'status'         => $request->input('status'),
            'bagian_id'      => $request->input('bagian_id'),
            'ruang_id'       => $request->input('ruang_id'),
            'lemari_id'      => $request->input('lemari_id'),
            'rak_id'         => $request->input('rak_id'),
            'kode_barang'    => $kode_barang,
            'barcode'        => $barcodeBase64,
        ]);
    }

    return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
}




    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $categories = Category::all();
        $ruangs = Ruang::orderBy('nama')->pluck('nama', 'id');
        $lemaris = Lemari::orderBy('nama')->pluck('nama', 'id');
        $raks = Rak::orderBy('nama')->pluck('nama', 'id');
        $bagians = Bagian::orderBy('nama_bagian')->pluck('nama_bagian', 'id');

        return view('barang.edit', compact('barang', 'categories', 'ruangs', 'lemaris', 'raks', 'bagians'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category'      => 'required|exists:categories,id',
            'join_date'     => 'required|date_format:d-m-Y',
            'full_name'     => 'required|string',
            'brand_name'    => 'required|string',
            'specification' => 'required|string',
            'fund_source'   => 'required|string',
            'year'          => 'required|digits:4',
            'status'        => 'required|in:Baik,Rusak',
            'bagian_id'     => 'required|exists:bagian,id',
            'ruang_id'      => 'required|exists:ruang,id',
            'lemari_id'     => 'nullable|exists:lemari,id',
            'rak_id'        => 'nullable|exists:rak,id',
        ]);

        $barang = Barang::findOrFail($id);

        $barang->category_id = $request->category;
        // Ubah tanggal ke format Y-m-d sebelum simpan
        $barang->join_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->join_date)->format('Y-m-d');
        $barang->full_name = $request->full_name;
        $barang->brand_name = $request->brand_name;
        $barang->specification = $request->specification;
        $barang->fund_source = $request->fund_source;
        $barang->year = $request->year;
        $barang->status = $request->status;
        $barang->bagian_id = $request->bagian_id;
        $barang->ruang_id = $request->ruang_id;
        $barang->lemari_id = $request->lemari_id;
        $barang->rak_id = $request->rak_id;

        $barang->save();

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diupdate.');
    }


    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function show($id)
{
    $barang = Barang::with(['bagian', 'ruang', 'lemari', 'rak'])->findOrFail($id);
    return view('barang.show', compact('barang'));
}


    

    public function downloadIndex(Request $request)
    {
        $query = Barang::with(['bagian', 'ruang']);

        // Filter pencarian (search)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                    ->orWhere('specification', 'like', "%$search%")
                    ->orWhere('kode_barang', 'like', "%$search%");
            });
        }

        // Filter merk
        if ($request->filled('brand_name')) {
            $query->where('brand_name', 'like', '%' . $request->brand_name . '%');
        }

        // Filter ruang
        if ($request->filled('ruang_id')) {
            $query->where('ruang_id', $request->ruang_id);
        }

        // Filter sumber dana
        if ($request->filled('fund_source')) {
            $query->where('fund_source', 'like', '%' . $request->fund_source . '%');
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter tahun
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Filter bagian
        if ($request->filled('bagian_id')) {
            $query->where('bagian_id', $request->bagian_id);
        }

        $barang = $query->oldest()->paginate(10);
        $barang->appends(request()->query());

        // Untuk dropdown filter
        $ruangList = Ruang::orderBy('nama')->get();
        $bagianList = Bagian::orderBy('nama_bagian')->get();

        return view('download.index', compact('barang', 'ruangList', 'bagianList'));
    }
}
