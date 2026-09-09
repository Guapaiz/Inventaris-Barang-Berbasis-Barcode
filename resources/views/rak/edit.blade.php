@extends('layouts.app')

@section('content')

        <!-- Page Heading -->
        <div class="card shadow mb-4 py-3 px-4 mt-4">
            <h1 class="h3 mb-4 text-gray-800">Edit {{ $rak->nama }}</h1>
        </div>


        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('rak.update', $rak->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Rak</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama', $rak->nama) }}" required>
                        @error('nama')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('lemari.show', $rak->lemari_id) }}" class="btn btn-secondary">
                            <i class="fas fa-chevron-left me-2"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
@endsection