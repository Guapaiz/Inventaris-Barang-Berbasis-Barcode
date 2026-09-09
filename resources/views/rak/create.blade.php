@extends('layouts.app')

@section('content')

    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 text-gray-800">Tambah Rak</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('rak.store') }}" method="POST">
                @csrf

                <!-- Input hidden lemari_id -->
                <input type="hidden" name="lemari_id" value="{{ $lemariId }}">

                <div class="row">
                    <div class="col-xl-8">
                        <div class="mb-3">
                            <label class="form-label">Lemari</label>
                            <input type="text" class="form-control" value="{{ \App\Models\Lemari::find($lemariId)->nama }}"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Rak <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                                value="{{ old('jumlah') }}" min="1" autocomplete="off">
                            @error('jumlah')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4 border-top pt-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('lemari.show', $lemariId) }}" class="btn btn-secondary">Batal</a>

                </div>
            </form>
        </div>
    </div>
@endsection