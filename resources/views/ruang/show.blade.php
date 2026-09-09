@extends('layouts.app')

@section('content')

    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 text-gray-800 m-0">Ruang : {{ $ruang->nama }}</h1>

        @if($ruang->detail)
            <p class="mt-2 text-muted">Detail : {{ $ruang->detail }}</p>
        @endif
    </div>


    {{-- Daftar Lemari yang ada diruang ini --}}
    <div class="card shadow mb-4">
        <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Daftar lemari </h5>
                    <a href="{{ route('lemari.create', ['ruang_id' => $ruang->id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Lemari
                    </a>
                </div>
            @forelse ($lemariList as $lemari)
                <div class="card mb-3 border-left-primary shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ $lemari->nama }}</h6>
                        <div class="d-flex">
                            <div class="mx-1">
                                <a href="{{ route('lemari.show', $lemari->id) }}" class="btn btn-info btn-sm">Detail</a>
                            </div>
                                <div class="mx-1">
                                    <a href="{{ route('lemari.edit', $lemari->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                </div>
                                <div class="mx-1">
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#modalDeleteLemari{{ $lemari->id }}">
                                        Hapus
                                    </button>
                                </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Hapus Lemari -->
                <div class="modal fade" id="modalDeleteLemari{{ $lemari->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="modalDeleteLemariLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Hapus Lemari</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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

            @empty
                <div class="alert alert-info">
                    Tidak ada lemari di ruangan ini.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Tombol Edit, Hapus, Kembali --}}
    <div class="card shadow mb-4">
        <div class="card-body py-3 px-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="mb-2 mb-sm-0">
                    <a href="{{ route('ruang.index') }}" class="btn btn-secondary btn-responsive">
                        <i class="fas fa-chevron-left me-1 icon-responsive"></i> Kembali
                    </a>
                </div>
                <div>
                        <a href="{{ route('ruang.edit', $ruang->id) }}"
                            class="btn btn-primary me-2 btn-responsive mb-2 mb-sm-0">
                            <i class="fas fa-edit me-1 icon-responsive"></i> Edit Ruang
                        </a>

                        <button type="button" class="btn btn-danger btn-responsive mb-2 mb-sm-0" data-toggle="modal"
                            data-target="#modalDelete{{ $ruang->id }}">
                            <i class="fas fa-trash-alt me-1 icon-responsive"></i> Hapus Ruang
                        </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Ruang -->
    <div class="modal fade" id="modalDelete{{ $ruang->id }}" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Ruang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus ruang <strong>{{ $ruang->nama }}</strong>?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('ruang.destroy', $ruang->id) }}" method="POST">
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