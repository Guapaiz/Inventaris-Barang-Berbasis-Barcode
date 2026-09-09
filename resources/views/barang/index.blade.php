@extends('layouts.app')

@section('content')
    <!-- Judul Halaman -->
    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 text-gray-800 m-0">Daftar Barang</h1>
    </div>

    <!-- Card Utama -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Tombol & Pencarian -->
            <div class="row mb-3 align-items-center">
                <div class="col-lg-6 d-flex mb-2 mb-lg-0">
                    <a href="{{ route('barang.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i> Tambah Barang
                    </a>
                </div>
                <div class="col-lg-6">
                    <form action="{{ route('barang.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                placeholder="Cari barang..." autocomplete="off">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Filter -->
            <div class="mb-4">
                <form action="{{ route('barang.index') }}" method="GET">
                    <div class="form-row align-items-center">
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

                        <!-- Untuk layar kecil: Total Barang tampil satu baris sendiri -->
                        <div class="form-group col-12 d-md-none">
                            <label>Total Barang</label>
                            <div class="form-control text-white text-center fw-bold"
                                style="background-color: #17a2b8; border-color: #117a8b;">
                                {{ $totalBarang ?? 0 }}
                            </div>
                        </div>

                        <!-- Filter + Reset tombol -->
                        <div class="form-group col-12 col-md-6">
                            <label>&nbsp;</label>
                            <div class="d-flex flex-row" style="gap: 0.5rem;">
                                <button type="submit" class="btn btn-primary w-50">Filter</button>
                                <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary w-50">Reset</a>
                            </div>
                        </div>

                        <!-- Untuk layar besar: Total Barang tampil berdampingan -->
                        <div class="form-group col-md-2 d-none d-md-block">
                            <label>Total Barang</label>
                            <div class="form-control text-white text-center fw-bold"
                                style="background-color: #17a2b8; border-color: #117a8b;">
                                {{ $totalBarang ?? 0 }}
                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>

        <!-- Tabel Barang -->
        <div>
            @if ($barang->isEmpty())
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle mr-2"></i> Tidak ada data barang.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kode Barang</th>
                                <th>Ruang</th>
                                <th>Lemari</th>
                                <th>Kondisi</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $item)
                                <tr>
                                    <td class="text-center">{{ $barang->firstItem() + $loop->index }}</td>
                                    <td>{{ $item->full_name }}</td>

                                    <td>{{ $item->kode_barang }}</td>

                                    <td>{{ $item->ruang->nama ?? 'Tidak Ada Ruang' }}</td>
                                    <td>{{ $item->lemari->nama ?? '-' }}</td>
                                    <td>{{ $item->status }}</td>

                                    <td class="text-center">
                                        <a href="{{ route('barang.show', $item->id) }}" class="btn btn-sm btn-outline-info">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $barang->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
    </div>
@endsection