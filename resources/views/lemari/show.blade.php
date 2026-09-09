@extends('layouts.app')

@section('content')

    {{-- Judul Halaman --}}
    <div class="card shadow mb-4 mt-4">
        <div class="card-body py-3 px-4">
            <h1 class="h3 text-gray-800 mb-2">Ruang {{ $lemari->ruang->nama }} - {{ $lemari->nama }}</h1>
        </div>
    </div>

    {{-- Daftar Rak --}}
    <div class="card shadow mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Daftar Rak</h5>
                    <a href="{{ route('rak.create', ['lemari_id' => $lemari->id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Rak
                    </a>
            </div>

            @forelse ($lemari->rak as $rak)
                <div class="card mb-3 border-left-primary shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ $rak->nama }}</h6>
                        <div class="d-flex">
                            <div class="mx-1">
                                <a href="{{ route('rak.show', $rak->id) }}" class="btn btn-info btn-sm">Detail</a>
                            </div>
                                <div class="mx-1">
                                    <a href="{{ route('rak.edit', $rak->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                </div>
                                <div class="mx-1">
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#modalDeleteRak{{ $rak->id }}">
                                        Hapus
                                    </button>
                                </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Hapus Rak --}}
                <div class="modal fade" id="modalDeleteRak{{ $rak->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="modalDeleteRakLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Hapus Rak</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Yakin ingin menghapus rak <strong>{{ $rak->nama }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('rak.destroy', $rak->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Ya, Hapus!</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="alert alert-info">
                    Tidak ada rak di lemari ini.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Tombol Aksi Lemari --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <div
                class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3">
                <div class="mb-2 mb-sm-0">
                    <a href="{{ route('ruang.show', $lemari->ruang_id) }}" class="btn btn-secondary">
                        <i class="fas fa-chevron-left me-1"></i> Kembali
                    </a>
                </div>
                <div>
                    @auth
                        <a href="{{ route('lemari.edit', $lemari->id) }}" class="btn btn-primary me-2">
                            <i class="fas fa-edit me-1"></i> Edit Lemari
                        </a>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteLemari{{ $lemari->id }}">
                            <i class="fas fa-trash-alt me-1"></i> Hapus Lemari
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Hapus Lemari --}}
    <div class="modal fade" id="modalDeleteLemari{{ $lemari->id }}" tabindex="-1" role="dialog"
        aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Lemari</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus lemari <strong>{{ $lemari->nama }}</strong>?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('lemari.destroy', $lemari->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection