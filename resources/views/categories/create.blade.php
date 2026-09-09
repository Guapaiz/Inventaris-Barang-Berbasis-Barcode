@extends('layouts.app')

@section('content')

    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 mb-4 text-gray-800">Tambah Kategori Barang</h1>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            {{-- form add data --}}
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" autocomplete="off">

                    {{-- pesan error untuk name --}}
                    @error('name')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Kode Prefix <span class="text-danger">*</span></label>
                    <input type="text" name="code_prefix" class="form-control @error('code_prefix') is-invalid @enderror"
                        value="{{ old('code_prefix') }}" autocomplete="off">
                    @error('code_prefix')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                        rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="pt-4 pb-2 mt-5 border-top">
                    <div class="d-flex justify-content-between align-items-center pt-3">
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection