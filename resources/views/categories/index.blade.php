@extends('layouts.app')

@section('content')

<div class="card shadow mb-4 py-3 px-4 mt-4">
    <h1 class="h3 text-gray-800 m-0">Kategori Barang</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-lg-6 mb-2">
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i> Tambah Kategori Barang
                </a>
            </div>
            <div class="col-lg-6">
                <form action="{{ route('categories.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            value="{{ request('search') }}" placeholder="Cari Barang..." autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse ($categories as $category)
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-left-primary shadow h-100 py-2 text-center">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Kategori</div>
                        <div class="h5 mb-3 font-weight-bold text-gray-800">{{ $category->name }}</div>
                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-primary">
                            Detail <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle mr-2"></i> Tidak ada data kategori
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $categories->links() }}
        </div>
    </div>
</div>

@endsection
