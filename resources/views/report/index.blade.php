@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Barang</h1>
    </div>

    <!-- Filter Form -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('report.filter') }}" method="GET">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="ruang_id">Ruang</label>
                        <select name="ruang_id" class="form-control">
                            <option value="">Semua</option>
                            @foreach($ruangList as $ruang)
                                <option value="{{ $ruang->id }}" {{ request('ruang_id') == $ruang->id ? 'selected' : '' }}>
                                    {{ $ruang->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="bagian_id">Bagian</label>
                        <select name="bagian_id" class="form-control">
                            <option value="">Semua</option>
                            @foreach($bagianList as $bagian)
                                <option value="{{ $bagian->id }}" {{ request('bagian_id') == $bagian->id ? 'selected' : '' }}>
                                    {{ $bagian->nama_bagian }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="category_id">Kategori</label>
                        <select name="category_id" class="form-control">
                            <option value="">Semua</option>
                            @foreach($kategoriList as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('category_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="">Semua</option>
                            <option value="Baik" {{ request('status') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak" {{ request('status') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="year">Tahun</label>
                        <input type="number" name="year" class="form-control" placeholder="Tulis Tahun"
                            value="{{ request('year') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="brand_name">Merk</label>
                        <input type="text" name="brand_name" class="form-control" placeholder="Tulis Merk"
                            value="{{ request('brand_name') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="fund_source">Sumber Dana</label>
                        <input type="text" name="fund_source" class="form-control" placeholder="Tulis Sumber Dana"
                            value="{{ request('fund_source') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="text" name="start_date"
                            class="form-control datepicker @error('start_date') is-invalid @enderror"
                            value="{{ old('start_date', request('start_date')) }}" autocomplete="off"
                            placeholder="dd-mm-yyyy">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="text" name="end_date"
                            class="form-control datepicker @error('end_date') is-invalid @enderror"
                            value="{{ old('end_date', request('end_date')) }}" autocomplete="off" placeholder="dd-mm-yyyy">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    @if(isset($barang) && count($barang) > 0)
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-file-alt me-1"></i> Laporan Barang
                    @if($start_date && $end_date)
                        :
                        {{ \Carbon\Carbon::parse($start_date)->translatedFormat('d F Y') }}
                        – {{ \Carbon\Carbon::parse($end_date)->translatedFormat('d F Y') }}
                    @endif
                </h6>
                <a
                    href="{{ route('report.print', array_merge([$start_date ?? '-', $end_date ?? '-'], request()->only(['ruang_id', 'bagian_id', 'status', 'year', 'brand_name', 'fund_source', 'category_id']))) }}">
                    <i class="fas fa-print me-1"></i> Print PDF
                </a>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    Total Barang: <strong>{{ $barang->count() }}</strong>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>No.</th>
                                <th>Nama Lengkap</th>
                                <th>Merk</th>
                                <th>Spesifikasi</th>
                                <th>Kondisi</th>
                                <th>Sumber Dana</th>
                                <th>Tahun</th>
                                <th>Tanggal Masuk</th>
                                <th>Kode Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($barang as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->full_name }}</td>
                                    <td>{{ $item->brand_name }}</td>
                                    <td>{{ $item->specification }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->fund_source }}</td>
                                    <td>{{ $item->year }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->join_date)->format('d-m-Y') }}</td>
                                    <td>{{ $item->kode_barang }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @elseif(request()->all())
        <div class="alert alert-warning text-center">
            Data tidak ditemukan untuk filter yang dipilih.
        </div>
    @endif
@endsection

@section('scripts')
    <script src="{{ asset('vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('vendor/flatpickr/id.js') }}"></script>
    <script>
        flatpickr('.datepicker', {
            dateFormat: 'd-m-Y',
            allowInput: true,
            locale: 'id'
        });
    </script>
@endsection