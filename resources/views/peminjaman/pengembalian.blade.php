@extends('layouts.app')

@section('title', 'Pengembalian Barang')

@section('content')
    <div class="card shadow mt-4">
        <div class="card-header">
            <h5 class="m-0 font-weight-bold text-primary">Form Pengembalian Barang</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- FORM INPUT MANUAL --}}
            <form id="pengembalian-form" action="{{ route('peminjaman.pengembalian.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="kode_barang">Masukkan Kode Barang</label>
                    <input type="text" name="kode_barang" id="kode_barang" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Proses Pengembalian</button>
                <a href="{{ route('peminjaman.index', ['tab' => 'peminjaman']) }}" class="btn btn-secondary ml-2">Kembali</a>
            </form>

            {{-- TOMBOL SCAN BARCODE --}}
            <div class="mt-4">
                <button id="btn-scan" class="btn btn-info">
                    <i class="fas fa-barcode"></i> Scan Barcode
                </button>
            </div>

            {{-- AREA KAMERA --}}
            <div id="scan-section" class="mt-4 d-none">
                <div class="alert alert-secondary text-center">Arahkan kamera ke barcode barang.</div>

                <div id="preview" class="border rounded-3 position-relative">
                    <div class="barcode-box"></div>
                </div>
                <div class="text-center mt-3">
                    <button id="btn-cancel-scan" class="btn btn-sm btn-danger">Batal</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/quagga/quagga.min.js') }}"></script>

    <style>
        #preview {
            position: relative;
            width: 100%;
            height: 400px;
            background-color: #000;
        }

        #preview video,
        canvas.drawingBuffer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
        }

        .barcode-box {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 60%;
            height: 30%;
            transform: translate(-50%, -50%);
            border: 2px dashed #ffffff;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.6);
            z-index: 10;
            pointer-events: none;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const btnScan = document.getElementById('btn-scan');
            const btnCancel = document.getElementById('btn-cancel-scan');
            const scanSection = document.getElementById('scan-section');
            const inputKode = document.getElementById('kode_barang');
            const form = document.getElementById('pengembalian-form');

            function startScan() {
                scanSection.classList.remove('d-none');

                Quagga.init({
                    inputStream: {
                        type: "LiveStream",
                        target: document.querySelector('#preview'),
                        constraints: {
                            facingMode: "environment",
                            width: { min: 640 },
                            height: { min: 480 }
                        }
                    },
                    decoder: {
                        readers: ["code_128_reader"]
                    },
                    locate: true
                }, function (err) {
                    if (err) {
                        console.error("Quagga init error:", err);
                        alert("Gagal mengakses kamera. Pastikan izin kamera diaktifkan.");
                        return;
                    }
                    Quagga.start();
                });

                Quagga.onDetected(function (result) {
                    const code = result.codeResult.code;
                    if (code.length >= 4) {
                        Quagga.stop();
                        inputKode.value = code;
                        form.submit();
                    }
                });
            }

            function stopScan() {
                Quagga.stop();
                scanSection.classList.add('d-none');
            }

            btnScan.addEventListener('click', startScan);
            btnCancel.addEventListener('click', stopScan);
        });
    </script>
@endpush
