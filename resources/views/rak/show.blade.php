@extends('layouts.app')

@section('content')


{{-- Judul Halaman Bertingkat Ukuran Menurun --}}
<div class="card shadow mb-4 mt-4">
    <div class="card-body py-3 px-4">
        <h3 class="text-gray-800 mb-2">Ruang: {{ $rak->lemari->ruang->nama }}- {{ $rak->lemari->nama }}</h3>
        <h5 class="text-gray-600 ms-4"> No : {{ $rak->nama }}</h5>
    </div>
</div>

{{-- Daftar Barang dalam Tabel --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <h5 class="mb-4">Barang di Rak Ini</h5>

        @if ($rak->barang->isEmpty())
        <div class="alert alert-info mb-0">Tidak ada barang di rak ini.</div>
        @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Merk</th>
                        <th>Spesifikasi</th>
                        <th>Sumber Dana</th>
                        <th>Tahun</th>
                        <th>Tanggal Masuk</th>
                        <th>Kode Barang</th>
                        <th>Status</th>
                        <th>Bagian</th>
                        <th>Ruang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rak->barang as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ $item->brand_name }}</td>
                        <td>{{ $item->specification }}</td>
                        <td>{{ $item->fund_source }}</td>
                        <td class="text-center">{{ $item->year }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->join_date)->format('d-m-Y') }}</td>
                        <td>{{ $item->kode_barang }}</td>
                        <td class="text-center">{{ $item->status }}</td>
                        <td>{{ $item->bagian->nama_bagian ?? '-' }}</td>
                        <td>{{ $item->ruang->nama ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

{{-- Tombol Kembali --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between flex-wrap gap-3">
            <a href="{{ route('lemari.show', $rak->lemari_id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection