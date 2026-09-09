@extends('layouts.app')

@section('content')

    {{-- Page Title --}}
    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 text-gray-800 m-0">Detail Kategori Barang</h1>
    </div>

    <div class="card shadow rounded-4 mb-4">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $category->name }}</p>
            <p><strong>Kode Prefix:</strong> {{ $category->code_prefix }}</p>

            <h6 class="text-muted">Description:</h6>
            <p>{{ $category->description ?? '-' }}</p>
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="card-body py-3 px-4"> {{-- lebih ramping --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="mb-2 mb-sm-0">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-responsive">
                        <i class="fas fa-chevron-left me-1 icon-responsive"></i> Kembali
                    </a>
                </div>
                <div>
                        <a href="{{ route('categories.edit', $category->id) }}"
                            class="btn btn-primary me-2 btn-responsive mb-2 mb-sm-0">
                            <i class="fas fa-edit me-1 icon-responsive"></i> Edit
                        </a>

                        <button type="button" class="btn btn-danger btn-responsive mb-2 mb-sm-0" data-toggle="modal"
                            data-target="#modalDelete{{ $category->id }}">
                            <i class="fas fa-trash-alt me-1 icon-responsive"></i> Hapus
                        </button>
                </div>
            </div>
        </div>
    </div>




    {{-- Modal hapus data --}}
    <div class="modal fade" id="modalDelete{{ $category->id }}" tabindex="-1" role="dialog"
        aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDeleteLabel">
                        <i class="fas fa-trash mr-2"></i> Delete Category
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {{-- informasi data yang akan dihapus --}}
                    <p>
                        Yakin ingin menghapus <strong>{{ $category->name }}</strong>?
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    {{-- button hapus data --}}
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, hapus!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection