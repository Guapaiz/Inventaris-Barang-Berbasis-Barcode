@extends('layouts.app')

@section('title', 'Detail Barang')

@section('content')
    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Barang</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Barang</h6>
        </div>


        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{ $barang->full_name }}</td>
                </tr>
                <tr>
                    <th>Spesifikasi</th>
                    <td>{{ $barang->specification }}</td>
                </tr>
                <tr>
                    <th>Kode Barang</th>
                    <td>{{ $barang->kode_barang }}</td>
                </tr>
                <tr>
                    <th>Merk</th>
                    <td>{{ $barang->brand_name }}</td>
                </tr>
                <tr>
                    <th>Tahun</th>
                    <td>{{ $barang->year }}</td>
                </tr>
                <tr>
                    <th>Sumber Dana</th>
                    <td>{{ $barang->fund_source }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $barang->status }}</td>
                </tr>
                <tr>
                    <th>Tanggal Masuk</th>
                    <td>{{ \Carbon\Carbon::parse($barang->join_date)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Ruang</th>
                    <td>{{ $barang->ruang->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Bagian</th>
                    <td>{{ $barang->bagian->nama_bagian ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Lemari</th>
                    <td>{{ $barang->lemari->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Rak</th>
                    <td>{{ $barang->rak->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Barcode</th>
                    <td>
                        @if($barang->barcode)
                            <img src="data:image/png;base64,{{ $barang->barcode }}" alt="Barcode" class="img-fluid"
                                style="max-height: 100px;">
                        @else
                            <em>Tidak tersedia</em>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Download Barcode</th>
                    <td>
                        @if($barang->barcode)
                            <a href="{{ route('download.barcode', $barang->id) }}" class="btn btn-success" target="_blank">
                                <i class="fas fa-download"></i> Unduh Barcode
                            </a>
                        @else
                            <em>Barcode tidak tersedia</em>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div
                class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3">
                <div class="mb-2 mb-sm-0">
                    <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                        <i class="fas fa-chevron-left me-1"></i> Kembali
                    </a>
                </div>
                <div>
                    <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-1"></i> Edit Barang
                    </a>

                    <!-- Tombol Hapus -->
                    <button class="btn btn-danger me-2" data-toggle="modal" data-target="#modalDelete{{ $barang->id }}">
                        <i class="fas fa-trash-alt me-1"></i> Hapus Barang
                    </button>

                    <!-- Tombol Keluarkan -->
                    @if(!$barang->is_keluar)
                        <button class="btn btn-info" data-toggle="modal" data-target="#keluarkanModal{{ $barang->id }}">
                            <i class="fas fa-sign-out-alt me-1"></i> Keluarkan
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="modalDelete{{ $barang->id }}" tabindex="-1" role="dialog"
        aria-labelledby="modalDeleteLabel{{ $barang->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Barang</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus barang <strong>{{ $barang->full_name }}</strong>
                    ({{ $barang->kode_barang }})?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, hapus!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Keluarkan -->
    @if(!$barang->is_keluar)
        <div class="modal fade" id="keluarkanModal{{ $barang->id }}" tabindex="-1" role="dialog"
            aria-labelledby="keluarkanModalLabel{{ $barang->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('barangkeluar.store') }}" method="POST" class="modal-content">
                    @csrf
                    <input type="hidden" name="barang_id" value="{{ $barang->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title">Keluarkan Barang</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tujuan <span class="text-danger">*</span></label>
                            <input type="text" name="tujuan_ruangan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Penerima <span class="text-danger">*</span></label>
                            <input type="text" name="penerima" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Keterangan <span class="text-danger">*</span></label>
                            <textarea name="keterangan" class="form-control" rows="2" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Keluarkan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection