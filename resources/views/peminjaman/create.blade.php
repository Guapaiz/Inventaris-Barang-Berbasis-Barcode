@extends('layouts.app')

@section('title', 'Form Peminjaman')

@section('content')
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Form Peminjaman Barang</h5>
        </div>
        <div class="card-body ">

            {{-- Filter Kategori --}}
            <div class="mb-1">
                <form method="GET" action="{{ route('peminjaman.create') }}">
                    <div class="form-row align-items-end mt-0 mb-0">
                        <div class="form-group col-6 col-md-3">
                            <label for="category_id">Kategori</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">-- Semua Kategori --</option>
                                @foreach ($kategoriList as $kategori)
                                    <option value="{{ $kategori->id }}" {{ request('category_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-6 col-md-4">
                            <label>&nbsp;</label>
                            <div class="d-flex align-items-end" style="gap: 0.5rem;">
                                {{-- Total Barang --}}
                                <div class="form-group mb-0">
                                    <label>Total Barang</label>
                                    <div class="form-control text-white text-center fw-bold"
                                        style="background-color: #17a2b8; border-color: #117a8b; width: 120px;">
                                        {{ $totalBarang }}
                                    </div>
                                </div>
                                {{-- Tombol Filter --}}
                                <div class="form-group mb-0">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter"></i> Tampilkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- FORM PEMINJAMAN --}}
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama_peminjam">Nama Peminjam <span class="text-danger">*</span></label>
                    <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="jenis_peminjam">Jenis Peminjam <span class="text-danger">*</span></label>
                    <select name="jenis_peminjam" id="jenis_peminjam" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Guru">Guru</option>
                        <option value="Siswa">Siswa</option>
                        <option value="Umum">Umum</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tujuan_peminjaman">Tujuan Peminjaman <span class="text-danger">*</span></label>
                    <input type="text" name="tujuan_peminjaman" id="tujuan_peminjaman" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_pinjam">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control"
                        value="{{ now()->format('Y-m-d') }}" readonly>
                </div>

                <div class="form-group">
                    <label>Pilih Barang yang Akan Dipinjam <span class="text-danger">*</span></label>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th><input type="checkbox" id="select-all"> Pinjam Semua</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Spesifikasi</th>
                                    <th>Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barang as $item)
                                    <tr>
                                        <td><input type="checkbox" name="barang_ids[]" value="{{ $item->id }}"></td>
                                        <td>{{ $item->kode_barang }}</td>
                                        <td>{{ $item->full_name }}</td>
                                        <td>{{ $item->specification }}</td>
                                        <td>
                                            <span class="badge badge-success">{{ $item->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Tidak ada barang tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Simpan Peminjaman</button>
                <a href="{{ route('peminjaman.index', ['tab' => 'peminjaman']) }}"
                    class="btn btn-secondary mt-3">Kembali</a>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('select-all').addEventListener('change', function () {
            let checkboxes = document.querySelectorAll('input[name="barang_ids[]"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>
@endsection