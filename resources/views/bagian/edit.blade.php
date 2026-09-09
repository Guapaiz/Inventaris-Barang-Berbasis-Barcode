@extends('layouts.app')

@section('content')

<div class="card shadow mb-4 py-3 px-4 mt-4">
    <h1 class="h3 mb-4 text-gray-800">Edit Bagian</h1>
</div>


<div class="bg-white rounded-4 shadow-sm p-4 mb-5">
    <form action="{{ route('bagian.update', $bagian->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="nama_bagian">Nama Bagian</label>
            <input type="text" id="nama_bagian" name="nama_bagian" class="form-control" value="{{ old('nama_bagian', $bagian->nama_bagian) }}" required>
            @error('nama_bagian')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('bagian.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

@endsection