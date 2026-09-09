@extends('layouts.app')

@section('content')

    <!-- Judul Halaman -->
    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Ruang : {{ $ruang->nama }}</h1>
    </div>

    <!-- Form Edit Ruang - Full Width -->
    <div class="card shadow mb-4 py-3 px-4">
        <div class="card-body">
            <form action="{{ route('ruang.update', $ruang->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Input Nama -->
                <div class="form-group">
                    <label for="nama">Nama Ruang</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $ruang->nama) }}"
                        required>
                    @error('nama')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Detail -->
                <div class="form-group mt-3">
                    <label for="detail">Detail Ruang</label>
                    <textarea name="detail" id="detail" class="form-control"
                        rows="3">{{ old('detail', $ruang->detail) }}</textarea>
                    @error('detail')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-4 d-flex justify-content-between flex-wrap">
                    <a href="{{ route('ruang.show', $ruang) }}"
                        class="btn btn-secondary d-flex align-items-center text-nowrap mb-2">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary d-flex align-items-center text-nowrap mb-2">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection