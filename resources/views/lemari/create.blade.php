@extends('layouts.app')

@section('content')
<!-- Page Heading -->
 <div class="card shadow mb-4 py-3 px-4 mt-4">
    <h1 class="h3 text-gray-800">Tambah Lemari</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('lemari.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lemari <span class="text-danger">*</span></label>
                <input type="text" id="nama" name="nama"
                    class="form-control @error('nama') is-invalid @enderror"
                    value="{{ old('nama') }}" autocomplete="off" autofocus>
                @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Ruang</label>
                <input type="text" class="form-control" value="{{ $ruangList->where('id', $defaultRuangId)->first()->nama ?? 'Ruang tidak ditemukan' }}" disabled>
                <input type="hidden" name="ruang_id" value="{{ $defaultRuangId }}">
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Save
                </button>
                <a href="{{ route('ruang.show', $defaultRuangId) }}" class="btn btn-secondary ms-2">
                    Cancel
                </a>

            </div>
        </form>
    </div>
</div>
@endsection