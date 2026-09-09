@extends('layouts.app')

@section('content')
    <div class="card shadow mb-4 py-3 px-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">Scan Barcode Barang</h1>
    </div>

    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <p class="text-center fs-5">Arahkan kamera ke barcode barang</p>
        <div id="preview" class="border rounded-3 position-relative">
            <div class="barcode-box"></div>
        </div>
        <div id="not-found-message" class="text-danger text-center mt-3 d-none">
            Barang tidak ditemukan.
        </div>
    </div>

    <div class="alert alert-info text-center d-none" id="barcode-result">
        <strong>Barcode:</strong> <span id="barcode-value"></span>
    </div>

    <div class="text-center mb-4">
        <button id="btn-rescan" class="btn btn-primary d-none">Scan Ulang</button>
    </div>

    <div id="barang-detail" class="mt-4 d-none">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title mb-3">Detail Barang</h5>
                <div class="row">
                    <div class="col-md-6 mb-2"><strong>Nama Barang:</strong> <span id="detail-nama"></span></div>
                    <div class="col-md-6 mb-2"><strong>Kode Barang:</strong> <span id="detail-kode"></span></div>
                    <div class="col-md-6 mb-2"><strong>Spesifikasi:</strong> <span id="detail-spesifikasi"></span></div>
                    <div class="col-md-6 mb-2"><strong>Bagian:</strong> <span id="detail-bagian"></span></div>
                    <div class="col-md-6 mb-2"><strong>Ruang:</strong> <span id="detail-ruang"></span></div>
                    <div class="col-md-6 mb-2"><strong>Lemari:</strong> <span id="detail-lemari"></span></div>
                    <div class="col-md-6 mb-2"><strong>Rak:</strong> <span id="detail-rak"></span></div>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="text-center mt-3 d-flex justify-content-center flex-wrap">
                    <div class="mx-2">
                        <a id="btn-edit" href="#" class="btn btn-warning">Edit</a>
                    </div>
                    <div class="mx-2">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusModal">
                            Hapus
                        </button>
                    </div>
                    <div class="mx-2">
                        <button id="btn-keluarkan-barang" class="btn btn-primary" data-toggle="modal"
                            data-target="#keluarkanModal">
                            Keluarkan Barang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Keluarkan Barang -->
    <div class="modal fade" id="keluarkanModal" tabindex="-1" role="dialog" aria-labelledby="keluarkanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('barangkeluar.store') }}" method="POST" class="modal-content" id="form-keluarkan-barang">
                @csrf
                <input type="hidden" name="barang_id" id="form-barang-id" required>
                <input type="hidden" name="kode_barang" id="form-kode-barang" required>
                <input type="hidden" name="full_name" id="form-nama-barang" required>
                <input type="hidden" name="specification" id="form-spesifikasi" required>
                <input type="hidden" name="bagian_id" id="form-bagian-id" required>
                <input type="hidden" name="ruang_id" id="form-ruang-id" required>
                <input type="hidden" name="status" value="Digunakan">

                <div class="modal-header">
                    <h5 class="modal-title" id="keluarkanModalLabel">Form Pengeluaran Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggal_keluar">Tanggal Keluar</label>
                        <input type="date" class="form-control" name="tanggal_keluar" id="tanggal_keluar" required>
                    </div>
                    <div class="form-group">
                        <label for="tujuan_ruangan">Tujuan Ruangan</label>
                        <input type="text" class="form-control" name="tujuan_ruangan" id="tujuan_ruangan" required>
                    </div>
                    <div class="form-group">
                        <label for="penerima">Penerima</label>
                        <input type="text" class="form-control" name="penerima" id="penerima" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" rows="2"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Keluarkan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-delete" method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus barang ini?</p>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- QuaggaJS & Script -->
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
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                alert("Browser ini tidak mendukung akses kamera.");
                return;
            }

            const facingModeSetting = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
                ? "environment"
                : "user";

            const btnRescan = document.getElementById('btn-rescan');
            const barcodeResult = document.getElementById('barcode-result');
            const barangDetail = document.getElementById('barang-detail');
            const barcodeValue = document.getElementById('barcode-value');
            const notFoundMsg = document.getElementById('not-found-message');

            function startScanner() {
                barcodeResult.classList.add('d-none');
                barangDetail.classList.add('d-none');
                notFoundMsg.classList.add('d-none');
                barcodeValue.innerText = '';
                btnRescan.classList.add('d-none');

                Quagga.init({
                    inputStream: {
                        type: "LiveStream",
                        target: document.querySelector('#preview'),
                        constraints: {
                            facingMode: facingModeSetting,
                            width: { min: 640 },
                            height: { min: 480 },
                            aspectRatio: { min: 1, max: 2 }
                        }
                    },
                    locator: { patchSize: "medium", halfSample: true },
                    numOfWorkers: navigator.hardwareConcurrency || 4,
                    decoder: { readers: ["code_128_reader"] },
                    locate: true
                }, function (err) {
                    if (err) {
                        console.error("Quagga init error:", err);
                        return;
                    }
                    Quagga.start();
                });
            }

            Quagga.onDetected(function (result) {
                const code = result.codeResult.code;

                if (code.length >= 4 && /^[a-zA-Z0-9]+$/.test(code)) {
                    Quagga.stop();
                    barcodeValue.innerText = code;
                    barcodeResult.classList.remove('d-none');
                    btnRescan.classList.remove('d-none');

                    fetch("{{ route('scan.search') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ kode: code })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            notFoundMsg.classList.add('d-none');
                            barangDetail.classList.remove('d-none');

                            document.getElementById('detail-nama').innerText = data.barang.nama;
                            document.getElementById('detail-kode').innerText = data.barang.kode;
                            document.getElementById('detail-spesifikasi').innerText = data.barang.spesifikasi;
                            document.getElementById('detail-bagian').innerText = data.barang.bagian;
                            document.getElementById('detail-ruang').innerText = data.barang.ruang;
                            document.getElementById('detail-lemari').innerText = data.barang.lemari;
                            document.getElementById('detail-rak').innerText = data.barang.rak;

                            document.getElementById('btn-edit').href = `/barang/${data.barang.id}/edit`;
                            document.getElementById('form-delete').action = `/barang/${data.barang.id}`;

                            document.getElementById('form-nama-barang').value = data.barang.nama;
                            document.getElementById('form-kode-barang').value = data.barang.kode;
                            document.getElementById('form-spesifikasi').value = data.barang.spesifikasi;
                            document.getElementById('form-bagian-id').value = data.barang.bagian_id;
                            document.getElementById('form-ruang-id').value = data.barang.ruang_id;
                        } else {
                            barangDetail.classList.add('d-none');
                            notFoundMsg.classList.remove('d-none');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        barangDetail.classList.add('d-none');
                        notFoundMsg.classList.remove('d-none');
                    });
                }
            });

            btnRescan.addEventListener('click', startScanner);
            startScanner();
        });
    </script>
@endsection
