@extends('layouts.app')

@section('title', 'Peminjaman Barang')

@section('content')
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Manajemen Peminjaman Barang</h5>
        </div>

        <div class="card-body">
            {{-- Tabs Navigation --}}
            <ul class="nav nav-tabs mb-3" id="peminjamanTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab == 'barang' ? 'active' : '' }}" id="tab-barang" data-toggle="tab"
                        href="#barang" role="tab">Daftar Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab == 'peminjaman' ? 'active' : '' }}" id="tab-peminjaman"
                        data-toggle="tab" href="#peminjaman" role="tab">Daftar Peminjaman Barang</a>
                </li>
            </ul>

            {{-- Tabs Content --}}
            <div class="tab-content" id="peminjamanTabContent">

                {{-- Tab Daftar Barang --}}
                <div class="tab-pane fade {{ $activeTab == 'barang' ? 'show active' : '' }}" id="barang" role="tabpanel"
                    class="mt-3">


                    {{-- Filter Kategori --}}
                    <div class="mb-3 pt-3 border-top">
                        <form method="GET" action="{{ route('peminjaman.index') }}">
                            <input type="hidden" name="tab" value="barang">

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

                                <!-- Untuk Mobile: Stack Vertikal -->
                                <div class="col-12 d-md-none mb-2">
                                    <div class="form-group">
                                        <label>Total Barang</label>
                                        <div class="form-control text-white text-center fw-bold"
                                            style="background-color: #17a2b8; border-color: #117a8b;">
                                            {{ $barangList->total() }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>

                                <!-- Untuk Desktop: Tetap Sejajar -->
                                <div class="form-group col-md-4 d-none d-md-flex align-items-end" style="gap: 0.5rem;">
                                    <div class="form-group mb-0">
                                        <label>Total Barang</label>
                                        <div class="form-control text-white text-center fw-bold"
                                            style="background-color: #17a2b8; border-color: #117a8b; width: 120px;">
                                            {{ $barangList->total() }}
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>


                    {{-- Tabel Daftar Barang --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Spesifikasi</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($barangList as $i => $barang)
                                    <tr>
                                        <td>{{ $barangList->firstItem() + $i }}</td>
                                        <td>{{ $barang->kode_barang }}</td>
                                        <td>{{ $barang->full_name }}</td>
                                        <td>{{ $barang->specification }}</td>
                                        <td>{{ $barang->category->name ?? '-' }}</td>
                                        <td>{{ ucfirst($barang->status) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Tidak ada barang tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $barangList->appends(request()->except('barang_page'))->appends(['tab' => 'barang'])->links('pagination::bootstrap-4') }}
                        </div>

                    </div>
                </div>


                {{-- Tab Daftar Peminjaman --}}
                <div class="tab-pane fade {{ $activeTab == 'peminjaman' ? 'show active' : '' }}" id="peminjaman"
                    role="tabpanel">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="d-flex justify-content-end mb-2">
                        <a href="{{ route('peminjaman.pengembalian.form') }}" class="btn btn-sm btn-success mr-2">
                            <i class="fas fa-undo"></i> Pengembalian
                        </a>
                        <a href="{{ route('peminjaman.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Peminjaman
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peminjam</th>
                                    <th>Jenis Peminjam</th>
                                    <th>Tujuan</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Tgl Kembali</th>
                                    <th>Status</th>
                                    <th>Barang Dipinjam</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peminjaman as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $p->nama_peminjam }}</td>
                                        <td>{{ ucfirst($p->jenis_peminjam) }}</td>
                                        <td>{{ $p->tujuan_peminjaman }}</td>
                                        <td>{{ date('d-m-Y', strtotime($p->tanggal_pinjam)) }}</td>
                                        <td>
                                            @if($p->tanggal_kembali)
                                                {{ date('d-m-Y', strtotime($p->tanggal_kembali)) }}
                                            @else
                                                <span class="text-muted">Belum dikembalikan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->status == 'Dikembalikan')
                                                <span class="badge badge-success">{{ $p->status }}</span>
                                            @else
                                                <span class="badge badge-warning">Belum Kembali</span>
                                            @endif
                                        </td>
                                        <td>
                                            <ul class="mb-0 pl-3">
                                                @foreach ($p->detail as $detail)
                                                    <li>
                                                        {{ $detail->barang->kode_barang }} - {{ $detail->barang->full_name }}
                                                        @if (!$detail->is_kembali)
                                                            <span class="badge badge-danger">Dipinjam</span>
                                                        @else
                                                            <span class="badge badge-success">Dikembalikan</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            @if ($p->status === 'Dikembalikan')
                                                <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus peminjaman ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted">Masih aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">Belum ada data peminjaman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $peminjaman->appends(request()->except('peminjaman_page'))->appends(['tab' => 'peminjaman'])->links('pagination::bootstrap-4') }}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Saat tab diklik, scroll ke konten tab
                const tabLinks = document.querySelectorAll('#peminjamanTab a[data-toggle="tab"]');
                tabLinks.forEach(tab => {
                    tab.addEventListener('shown.bs.tab', function (e) {
                        const tabContent = document.querySelector('#peminjamanTabContent');
                        if (tabContent) {
                            tabContent.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    });
                });

                // Jika ada tab yang aktif saat load, scroll juga
                const activeTabPane = document.querySelector('#peminjamanTabContent .tab-pane.show.active');
                if (activeTabPane) {
                    activeTabPane.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        </script>
    @endpush

@endsection