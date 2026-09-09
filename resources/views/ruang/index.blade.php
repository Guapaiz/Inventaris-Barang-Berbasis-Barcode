@extends('layouts.app')

@section('content')

    <!-- Card Judul -->
    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 text-gray-800 m-0">Ruangan</h1>
    </div>

    <!-- Card Konten -->
    <div class="card shadow mb-4">
        <div class="card-body">

            <!-- Tombol Tambah dan Form Pencarian -->
            <div class="row mb-3">
                <div class="col-lg-6 mb-2">
                    <a href="{{ route('ruang.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i> Tambah Ruangan
                    </a>
                </div>
                <div class="col-lg-6">
                    <form action="{{ route('ruang.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                placeholder="Cari Ruangan ..." autocomplete="off">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Daftar Ruangan -->
            <div class="row">
                @forelse ($ruang as $item)
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2 text-center">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Nama Ruang</div>
                                <div class="h5 mb-3 font-weight-bold text-gray-800">{{ $item->nama }}</div>
                                <a href="{{ route('ruang.show', $item->id) }}" class="btn btn-sm btn-primary">
                                    Detail <i class="fas fa-chevron-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle mr-2"></i> Tidak ada data ruang 
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $ruang->links() }}
            </div>

        </div>
    </div>

@endsection