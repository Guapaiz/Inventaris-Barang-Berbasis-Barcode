@extends('layouts.app')

@section('content')

    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 text-gray-800">Tambah Bagian</h1>
    </div>
    <div class="bg-white rounded-4 shadow-sm p-4">
        <form action="{{ route('bagian.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Bagian</label>
                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                    value="{{ old('nama') }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('bagian.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Simpan
                </button>
            </div>
        </form>
    </div>

@endsection