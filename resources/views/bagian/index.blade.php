@extends('layouts.app')

@section('content')

    <!-- Judul -->
    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 text-gray-800 m-0">Daftar Bagian</h1>
    </div>

    <!-- Gabungan Form Tambah & Pencarian dan Daftar Bagian -->
    <div class="card shadow mb-4 py-3 px-4">

        <!-- Form Tambah & Pencarian -->
        <div class="row align-items-center mb-4">
            <div class="col-lg-5 col-xl-6 mb-3 mb-lg-0">

                <a href="{{ route('bagian.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i> Tambahkan Bagian
                </a>

            </div>
            <div class="col-lg-7 col-xl-6">
                <form action="{{ route('bagian.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                            placeholder="Cari bagian ..." autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Bagian -->
        <div class="row">
            @forelse ($bagian as $item)
                <div class="col-12">
                    <div
                        class="bg-white rounded shadow-sm d-flex justify-content-between align-items-start flex-column flex-sm-row p-4 mb-4">
                        <div class="mb-3 mb-sm-0">
                            <p class="text-muted mb-1"><small>Nama Bagian:</small></p>
                            <h6 class="mb-0 text-break">{{ $item->nama_bagian }}</h6>
                        </div>


                        <div class="d-flex flex-column flex-sm-row align-items-start">
                            <!-- Tombol Edit -->
                            <a href="{{ route('bagian.edit', $item->id) }}" class="btn btn-warning btn-sm mb-2 mb-sm-0 mr-sm-2">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>

                            <!-- Tombol Hapus -->
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#modalDelete{{ $item->id }}">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </div>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="modalDelete{{ $item->id }}" data-backdrop="static" data-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalDeleteLabel{{ $item->id }}">
                                            <i class="fas fa-trash mr-2"></i> Hapus Bagian
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Yakin ingin menghapus <strong>{{ $item->nama_bagian }}</strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <form action="{{ route('bagian.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Ya, hapus!</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col">
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle mr-2"></i> Tidak ada bagian 
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mb-4">
            {{ $bagian->links() }}
        </div>
    </div>

@endsection