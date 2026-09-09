@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Barang Keluar</h1>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-lg-5 col-xl-6 mb-3 mb-lg-0"></div>
                <div class="col-lg-7 col-xl-6">
                    <form action="{{ route('barangkeluar.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                placeholder="Cari barang keluar..." autocomplete="off">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            @if ($barangkeluar->isEmpty())
                <div class="alert alert-info d-flex align-items-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Tidak ada barang keluar tersedia.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="table-primary">
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
                                <th>Tanggal Keluar</th>
                                <th>Tujuan Ruangan</th>
                                <th>Penerima</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangkeluar as $item)
                                <tr>
                                    <td>{{ $barangkeluar->firstItem() + $loop->index }}</td>
                                    <td>{{ $item->full_name ?? '-' }}</td>
                                    <td>{{ $item->brand_name ?? '-' }}</td>
                                    <td>{{ $item->specification ?? '-' }}</td>
                                    <td>{{ $item->fund_source ?? '-' }}</td>
                                    <td>{{ $item->year ?? '-' }}</td>
                                    <td>{{ $item->join_date ? \Carbon\Carbon::parse($item->join_date)->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $item->kode_barang ?? '-' }}</td>
                                    <td>{{ $item->status ?? '-' }}</td>
                                    <td>{{ $item->bagian->nama_bagian ?? 'Tidak Ada Bagian' }}</td>
                                    <td>{{ $item->ruang->nama ?? 'Tidak Ada Ruang' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') }}</td>
                                    <td>{{ $item->tujuan_ruangan ?? '-' }}</td>
                                    <td>{{ $item->penerima ?? '-' }}</td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>

                                    <td>
                                        <!-- Tombol trigger modal -->
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#modalDelete{{ $item->id }}">
                                            Hapus
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="modalLabel{{ $item->id }}">Konfirmasi Hapus</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        Apakah Anda yakin ingin menghapus data barang keluar
                                                        <strong>{{ $item->full_name }}</strong> ({{ $item->kode_barang }})?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('barangkeluar.destroy', $item->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $barangkeluar->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection