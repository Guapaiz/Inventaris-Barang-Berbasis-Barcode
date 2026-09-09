@extends('layouts.app')

@section('head')
<!-- Flatpickr CSS (lokal) -->
<link rel="stylesheet" href="{{ asset('vendor/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
<div class="card shadow mb-4 py-3 px-4 mt-4">
    <h1 class="h3 mb-4 text-gray-800">Edit Barang</h1>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('barang.update', $barang->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select name="category" class="form-control @error('category') is-invalid @enderror">
                        <option selected disabled value="">- Pilih Kategori -</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ (old('category', $barang->category_id) == $category->id) ? 'selected' : '' }}>
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
                    <input type="text" name="join_date" id="join_date" class="form-control @error('join_date') is-invalid @enderror"
                        value="{{ old('join_date', \Carbon\Carbon::parse($barang->join_date)->format('d-m-Y')) }}" autocomplete="off" placeholder="dd-mm-yyyy">
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
                        value="{{ old('full_name', $barang->full_name) }}" autocomplete="off">
                    @error('full_name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Merk <span class="text-danger">*</span></label>
                    <input type="text" name="brand_name" class="form-control @error('brand_name') is-invalid @enderror"
                        value="{{ old('brand_name', $barang->brand_name) }}" autocomplete="off">
                    @error('brand_name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Spesifikasi -->
            <div class="mb-3">
                <label>Spesifikasi <span class="text-danger">*</span></label>
                <textarea name="specification" class="form-control @error('specification') is-invalid @enderror"
                    rows="3">{{ old('specification', $barang->specification) }}</textarea>
                @error('specification')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Sumber Dana & Tahun -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Sumber Dana <span class="text-danger">*</span></label>
                    <input type="text" name="fund_source" class="form-control @error('fund_source') is-invalid @enderror"
                        value="{{ old('fund_source', $barang->fund_source) }}" autocomplete="off">
                    @error('fund_source')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tahun <span class="text-danger">*</span></label>
                    <input type="text" name="year" class="form-control @error('year') is-invalid @enderror"
                        value="{{ old('year', $barang->year) }}" autocomplete="off">
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
                        <option value="Baik" {{ (old('status', $barang->status) == 'Baik') ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak" {{ (old('status', $barang->status) == 'Rusak') ? 'selected' : '' }}>Rusak</option>
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
                        <option value="{{ $id }}" {{ (old('bagian_id', $barang->bagian_id) == $id) ? 'selected' : '' }}>
                            {{ $nama_bagian }}
                        </option>
                        @endforeach
                    </select>
                    @error('bagian_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Ruang, Lemari, Rak (full options) -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Ruang <span class="text-danger">*</span></label>
                    <select name="ruang_id" class="form-control @error('ruang_id') is-invalid @enderror">
                        <option selected disabled value="">- Pilih Ruang -</option>
                        @foreach ($ruangs as $id => $nama)
                        <option value="{{ $id }}" {{ (old('ruang_id', $barang->ruang_id) == $id) ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('ruang_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Lemari</label>
                    <select name="lemari_id" class="form-control @error('lemari_id') is-invalid @enderror">
                        <option value="">-- Pilih Lemari --</option>
                        @foreach ($lemaris as $id => $nama)
                        <option value="{{ $id }}" {{ (old('lemari_id', $barang->lemari_id) == $id) ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('lemari_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Rak</label>
                    <select name="rak_id" class="form-control @error('rak_id') is-invalid @enderror">
                        <option value="">-- Pilih Rak --</option>
                        @foreach ($raks as $id => $nama)
                        <option value="{{ $id }}" {{ (old('rak_id', $barang->rak_id) == $id) ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('rak_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update</button>
              <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<!-- Flatpickr JS (lokal) -->
<script src="{{ asset('vendor/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('vendor/flatpickr/id.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#join_date", {
            locale: "id",
            dateFormat: "d-m-Y",
            allowInput: true
        });

        const ruangSelect = document.querySelector('select[name="ruang_id"]');
        const lemariSelect = document.querySelector('select[name="lemari_id"]');
        const rakSelect = document.querySelector('select[name="rak_id"]');

        // Fungsi untuk fetch dan render lemari berdasarkan ruang
        function fetchLemari(ruangId, selectedLemariId = null) {
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
                        const selected = lemari.id == selectedLemariId ? 'selected' : '';
                        lemariSelect.innerHTML += `<option value="${lemari.id}" ${selected}>${lemari.nama}</option>`;
                    });
                });
        }

        // Fungsi untuk fetch dan render rak berdasarkan lemari
        function fetchRak(lemariId, selectedRakId = null) {
            if (!lemariId) {
                rakSelect.innerHTML = '<option value="">-- Pilih Rak --</option>';
                return;
            }
            fetch(`/get-rak?lemari_id=${lemariId}`)
                .then(res => res.json())
                .then(data => {
                    rakSelect.innerHTML = '<option value="">-- Pilih Rak --</option>';
                    data.forEach(rak => {
                        const selected = rak.id == selectedRakId ? 'selected' : '';
                        rakSelect.innerHTML += `<option value="${rak.id}" ${selected}>${rak.nama}</option>`;
                    });
                });
        }

        // Saat halaman load, jika ruang sudah ada, fetch lemari dan rak yg sesuai
        const ruangId = ruangSelect.value;
        const oldLemariId = '{{ old("lemari_id", $barang->lemari_id) }}';
        const oldRakId = '{{ old("rak_id", $barang->rak_id) }}';

        if (ruangId) {
            fetchLemari(ruangId, oldLemariId);
        }

        // Setelah lemari dipilih (bisa dari fetch lemari otomatis atau user select), fetch rak
        lemariSelect.addEventListener('change', function() {
            const lemariId = this.value;
            fetchRak(lemariId);
        });

        // Saat ruang berubah, fetch lemari dan reset rak
        ruangSelect.addEventListener('change', function() {
            const ruangId = this.value;
            fetchLemari(ruangId);
        });

        // Jika ada lemari terpilih dari awal (edit mode), fetch rak otomatis
        if (oldLemariId) {
            fetchRak(oldLemariId, oldRakId);
        }
    });
</script>
@endsection

