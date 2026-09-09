@extends('layouts.app')

@section('content')

    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Kategori Barang</h1>
    </div>

    <div class="bg-white rounded shadow-sm p-4 mb-4">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')


            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $category->name) }}" autocomplete="off">

                @error('name')
                    <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="code_prefix" class="form-label">Code Prefix <span class="text-danger">*</span></label>
                <input id="code_prefix" type="text" name="code_prefix"
                    class="form-control @error('code_prefix') is-invalid @enderror"
                    value="{{ old('code_prefix', $category->code_prefix) }}" autocomplete="off">

                @error('code_prefix')
                    <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" rows="3"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>

                @error('description')
                    <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                @enderror
            </div>


            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('categories.show', $category->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection