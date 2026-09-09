@extends('layouts.app')

@section('content')
    <!-- Judul Halaman -->
    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 text-gray-800 m-0">Download Barcode Barang</h1>
    </div>

    <!-- Card Utama -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Form Pencarian -->
            <div class="row mb-3 align-items-center">
                <div class="col-lg-6">
                    <form action="{{ route('download.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                placeholder="Cari barang..." autocomplete="off">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Filter -->
            <!-- Filter -->
            <div class="mb-4">
                <form action="{{ route('download.index') }}" method="GET">
                    <div class="form-row align-items-end">

                        {{-- Filter kolom 1 --}}
                        <div class="form-group col-6 col-md-3">
                            <label for="ruang_id">Ruang</label>
                            <select id="ruang_id" name="ruang_id" class="form-control">
                                <option value="">Semua</option>
                                @foreach($ruangList as $ruang)
                                    <option value="{{ $ruang->id }}" {{ request('ruang_id') == $ruang->id ? 'selected' : '' }}>
                                        {{ $ruang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-6 col-md-3">
                            <label for="bagian_id">Bagian</label>
                            <select id="bagian_id" name="bagian_id" class="form-control">
                                <option value="">Semua</option>
                                @foreach($bagianList as $bagian)
                                    <option value="{{ $bagian->id }}" {{ request('bagian_id') == $bagian->id ? 'selected' : '' }}>
                                        {{ $bagian->nama_bagian }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-6 col-md-3">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-control">
                                <option value="">Semua</option>
                                <option value="Baik" {{ request('status') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Rusak" {{ request('status') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                        </div>

                        <div class="form-group col-6 col-md-3">
                            <label for="year">Tahun</label>
                            <input type="number" id="year" name="year" value="{{ request('year') }}" class="form-control"
                                placeholder="angka tahun" min="1900" max="{{ date('Y') }}">
                        </div>

                        <div class="form-group col-6 col-md-3">
                            <label for="brand_name">Merk</label>
                            <input type="text" id="brand_name" name="brand_name" value="{{ request('brand_name') }}"
                                class="form-control" placeholder="Tulis Merk">
                        </div>

                        <div class="form-group col-6 col-md-3">
                            <label for="fund_source">Sumber Dana</label>
                            <input type="text" id="fund_source" name="fund_source" value="{{ request('fund_source') }}"
                                class="form-control" placeholder="Tulis Sumber dana">
                        </div>

                        {{-- Total Barang tampil sendiri --}}
                        <div class="form-group col-12 col-md-2">
                            <label>Total Barang</label>
                            <div class="form-control text-white text-center fw-bold"
                                style="background-color: #17a2b8; border-color: #117a8b;">
                                {{ $totalBarang ?? 0 }}
                            </div>
                        </div>

                        {{-- Tombol Filter & Reset dalam satu baris --}}
                        <div class="form-group col-12 col-md-4">
                            <label>&nbsp;</label>
                            <div class="d-flex" style="gap: 0.5rem;">
                                <button type="submit" class="btn btn-primary w-50">Filter</button>
                                <a href="{{ route('download.index') }}" class="btn btn-outline-secondary w-50">Reset</a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>


            <!-- Tabel atau Kartu Data -->
            @if($barang->isEmpty())
                <div class="alert alert-info">
                    Tidak ada barang yang ditemukan.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Spesifikasi</th>
                                <th>Ruang</th>
                                <th>Kode Barang</th>
                                <th>Barcode</th> <!-- preview barcode -->
                                <th>Download Barcode</th> <!-- tombol download -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barang as $item)
                                <tr>
                                    <td class="text-center">{{ $barang->firstItem() + $loop->index }}</td>
                                    <td>{{ $item->full_name }}</td>
                                    <td>{{ $item->specification }}</td>
                                    <td>{{ $item->ruang->nama ?? 'Tidak Ada Ruang' }}</td>
                                    <td class="text-monospace">{{ $item->kode_barang }}</td>

                                    <!-- Kolom preview barcode -->
                                    <td class="text-center">
                                        @if($item->barcode)
                                            <img src="data:image/png;base64,{{ $item->barcode }}" alt="Barcode {{ $item->kode_barang }}"
                                                style="max-height: 50px;">
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>

                                    <!-- Kolom tombol download -->
                                    <td class="text-center">
                                        @if($item->barcode)
                                            <a href="{{ route('download.barcode', $item->id) }}" class="btn btn-sm btn-success"
                                                target="_blank">
                                                <i class="fas fa-download"></i> Unduh
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $barang->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endsection