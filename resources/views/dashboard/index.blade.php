@extends('layouts.app')

@section('content')
    {{-- tampilkan pesan selamat datang --}}
    <div class="bg-white rounded shadow-sm p-4 mb-5 mt-4">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-3">
                <img class="img-fluid" src="{{ asset('sbadmin2/img/bg-dashboard.svg') }}" alt="Dashboard Image">
            </div>
            <div class="col-lg-9">
                <h4 class="mt-3 mt-lg-0 mb-2">
                    Selamat datang di <strong>Inventaris Barang Teknik Komputer dan Jaringan SMKN 7 Jember</strong>!
                </h4>
                <p class="text-muted fw-light mb-4">
                    Tool ini merupakan alat bantu untuk mencari dan mengelola barang dengan efisien.
                </p>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        {{-- menampilkan informasi jumlah barang per kategori --}}
        @foreach ($categories as $category)
            <div class="col-6 col-md-4 col-lg-6 col-xl-3 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jumlah {{ $category->name }}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $category->barang_count }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection