@extends('layouts.app')

@section('content')

    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 mb-4 text-gray-800">Tambah Ruang</h1>
    </div>


    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('ruang.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Ruang <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}" autocomplete="off" required>
                    @error('nama')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="detail" class="form-label">Detail Ruang</label>
                    <textarea name="detail" id="detail" class="form-control @error('detail') is-invalid @enderror"
                        rows="3">{{ old('detail') }}</textarea>
                    @error('detail')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('ruang.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>


@endsection