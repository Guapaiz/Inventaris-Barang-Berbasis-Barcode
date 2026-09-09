@extends('layouts.app')

@section('content')
    <!-- Page Heading -->

    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">Edit {{ $lemari->nama }}</h1>
    </div>


    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('lemari.update', $lemari->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lemari <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $lemari->nama) }}" required autofocus>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ruang_id" class="form-label">Ruang <span class="text-danger">*</span></label>
                        <select name="ruang_id" id="ruang_id" class="form-control @error('ruang_id') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih Ruang --</option>
                            @foreach ($ruangList as $ruang)
                                <option value="{{ $ruang->id }}" {{ old('ruang_id', $lemari->ruang_id) == $ruang->id ? 'selected' : '' }}>
                                    {{ $ruang->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('ruang_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('ruang.show', $lemari->ruang->id) }}" class="btn btn-secondary">
                        <i class="fas fa-chevron-left me-1"></i> Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection