@extends('layouts.app')

@section('head')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/flatpickr/flatpickr.min.css') }}">

@endsection

@section('content')
    <!-- Page Heading -->
    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 mb-4 text-gray-800">Tambah Barang</h1>
    </div>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category" class="form-control @error('category') is-invalid @enderror">
                            <option selected disabled value="">- Pilih Kategori -</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                        <input type="text" name="join_date" id="join_date"
                            class="form-control @error('join_date') is-invalid @enderror" value="{{ old('join_date') }}"
                            autocomplete="off" placeholder="dd-mm-yyyy">
                        @error('join_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Nama & Merk -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                            value="{{ old('full_name') }}" autocomplete="off">
                        @error('full_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Merk <span class="text-danger">*</span></label>
                        <input type="text" name="brand_name" class="form-control @error('brand_name') is-invalid @enderror"
                            value="{{ old('brand_name') }}" autocomplete="off">
                        @error('brand_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Spesifikasi -->
                <div class="mb-3">
                    <label>Spesifikasi <span class="text-danger">*</span></label>
                    <textarea name="specification" class="form-control @error('specification') is-invalid @enderror"
                        rows="3">{{ old('specification') }}</textarea>
                    @error('specification')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sumber Dana & Tahun -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Sumber Dana <span class="text-danger">*</span></label>
                        <input type="text" name="fund_source"
                            class="form-control @error('fund_source') is-invalid @enderror" value="{{ old('fund_source') }}"
                            autocomplete="off">
                        @error('fund_source')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tahun <span class="text-danger">*</span></label>
                        <input type="text" name="year" class="form-control @error('year') is-invalid @enderror"
                            value="{{ old('year') }}" autocomplete="off">
                        @error('year')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Status & Bagian -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status Barang <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="Baik" {{ old('status') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak" {{ old('status') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Bagian <span class="text-danger">*</span></label>
                        <select name="bagian_id" class="form-control @error('bagian_id') is-invalid @enderror">
                            <option selected disabled value="">- Pilih Bagian -</option>
                            @foreach ($bagians as $id => $nama_bagian)
                                <option value="{{ $id }}" {{ old('bagian_id') == $id ? 'selected' : '' }}>
                                    {{ $nama_bagian }}
                                </option>
                            @endforeach
                        </select>
                        @error('bagian_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Ruang, Lemari, Rak -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Ruang <span class="text-danger">*</span></label>
                        <select name="ruang_id" id="ruang_id" class="form-control @error('ruang_id') is-invalid @enderror">
                            <option selected disabled value="">- Pilih Ruang -</option>
                            @foreach ($ruangs as $id => $nama)
                                <option value="{{ $id }}" {{ old('ruang_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>
                        @error('ruang_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Lemari</label>
                        <select name="lemari_id" id="lemari_id"
                            class="form-control @error('lemari_id') is-invalid @enderror">
                            <option value="">-- Pilih Lemari --</option>
                            @if(old('lemari_id') && old('ruang_id'))
                                @foreach ($lemaris as $id => $nama)
                                    <option value="{{ $id }}" {{ old('lemari_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('lemari_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Rak</label>
                        <select name="rak_id" id="rak_id" class="form-control @error('rak_id') is-invalid @enderror">
                            <option value="">-- Pilih Rak --</option>
                            @if(old('rak_id') && old('lemari_id'))
                                @foreach ($raks as $id => $nama)
                                    <option value="{{ $id }}" {{ old('rak_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('rak_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Jumlah Barang <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_barang"
                            class="form-control @error('jumlah_barang') is-invalid @enderror"
                            value="{{ old('jumlah_barang', 1) }}" min="1" max="100">
                        @error('jumlah_barang')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

        

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Flatpickr JS -->
    <script src="{{ asset('vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('vendor/flatpickr/id.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi Flatpickr dengan locale Indonesia dan format tanggal dd-mm-yyyy
            flatpickr("#join_date", {
                locale: "id",
                dateFormat: "d-m-Y",
                allowInput: true,
            });

            // Dropdown dinamis: Ruang → Lemari
            const ruangSelect = document.getElementById('ruang_id');
            const lemariSelect = document.getElementById('lemari_id');
            const rakSelect = document.getElementById('rak_id');

            ruangSelect.addEventListener('change', function () {
                const ruangId = this.value;
                if (!ruangId) {
                    lemariSelect.innerHTML = '<option value="">-- Pilih Lemari --</option>';
                    rakSelect.innerHTML = '<option value="">-- Pilih Rak --</option>';
                    return;
                }

                fetch(`/get-lemari?ruang_id=${ruangId}`)
                    .then(res => res.json())
                    .then(data => {
                        lemariSelect.innerHTML = '<option value="">-- Pilih Lemari --</option>';
                        rakSelect.innerHTML = '<option value="">-- Pilih Rak --</option>';
                        data.forEach(lemari => {
                            lemariSelect.innerHTML += `<option value="${lemari.id}">${lemari.nama}</option>`;
                        });
                    })
                    .catch(() => {
                        lemariSelect.innerHTML = '<option value="">-- Pilih Lemari --</option>';
                        rakSelect.innerHTML = '<option value="">-- Pilih Rak --</option>';
                    });
            });

            // Dropdown dinamis: Lemari → Rak
            lemariSelect.addEventListener('change', function () {
                const lemariId = this.value;
                if (!lemariId) {
                    rakSelect.innerHTML = '<option value="">-- Pilih Rak --</option>';
                    return;
                }

                fetch(`/get-rak?lemari_id=${lemariId}`)
                    .then(res => res.json())
                    .then(data => {
                        rakSelect.innerHTML = '<option value="">-- Pilih Rak --</option>';
                        data.forEach(rak => {
                            rakSelect.innerHTML += `<option value="${rak.id}">${rak.nama}</option>`;
                        });
                    })
                    .catch(() => {
                        rakSelect.innerHTML = '<option value="">-- Pilih Rak --</option>';
                    });
            });
        });
    </script>
@endsection