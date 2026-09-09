@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card shadow mb-4 py-3 px-4 mt-4">
            <h1 class="h3 mb-0 text-gray-800">Grafik Barang</h1>
        </div>

        {{-- Chart Bagian (Bar) --}}
        <div class="card shadow mb-4 p-4">
            <h5 class="mb-3">Jumlah Barang Berdasarkan Bagian</h5>
            @if(count($dataBagian) > 0)
                <canvas id="chartBagian" height="100"></canvas>
            @else
                <p class="text-center text-muted mb-0">Tidak ada data</p>
            @endif
        </div>

        {{-- Chart Ruang & Sumber Dana (Doughnut) --}}
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow p-4 h-100">
                    <h5 class="mb-3">Jumlah Barang per Ruang</h5>
                    @if(count($dataRuang) > 0)
                        <canvas id="chartRuangDoughnut" width="300" height="300"></canvas>
                    @else
                        <p class="text-center text-muted mb-0">Tidak ada data</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow p-4 h-100">
                    <h5 class="mb-3">Jumlah Barang Berdasarkan Sumber Dana</h5>
                    @if(count($dataFundSource) > 0)
                        <canvas id="chartFundSource" width="300" height="300"></canvas>
                    @else
                        <p class="text-center text-muted mb-0">Tidak ada data</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Chart Tahun (Line) --}}
        <div class="card shadow mb-4 p-4">
            <h5 class="mb-3">Jumlah Barang per Tahun</h5>
            @if(count($dataTahun) > 0)
                <canvas id="chartTahun" height="100"></canvas>
            @else
                <p class="text-center text-muted mb-0">Tidak ada data</p>
            @endif
        </div>

        {{-- Chart Status (Bar) --}}
        <div class="card shadow mb-4 p-4">
            <h5 class="mb-3">Jumlah Barang Berdasarkan Status</h5>
            @if(count($dataStatus) > 0)
                <canvas id="chartStatus" height="100"></canvas>
            @else
                <p class="text-center text-muted mb-0">Tidak ada data</p>
            @endif
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function generateColors(count) {
                const colors = [];
                for (let i = 0; i < count; i++) {
                    colors.push(`hsl(${i * 360 / count}, 70%, 60%)`);
                }
                return colors;
            }

            // Chart: Bagian (Bar)
            new Chart(document.getElementById('chartBagian'), {
                type: 'bar',
                data: {
                    labels: @json($labelsBagian),
                    datasets: [{
                        label: 'Jumlah Barang',
                        data: @json($dataBagian),
                        backgroundColor: generateColors(@json(count($dataBagian)))
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: { display: true, text: 'Jumlah Barang Berdasarkan Bagian (bar_chart)' }
                    },
                    scales: {
                        y: { beginAtZero: true, precision: 0 }
                    }
                }
            });

            // Chart: Ruang (Doughnut)
            new Chart(document.getElementById('chartRuangDoughnut'), {
                type: 'doughnut',
                data: {
                    labels: @json($labelsRuang),
                    datasets: [{
                        label: 'Jumlah Barang',
                        data: @json($dataRuang),
                        backgroundColor: generateColors(@json(count($dataRuang)))
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: { display: true, text: 'Jumlah Barang per Ruang (Doughnut_chart)' }
                    }
                }
            });

            // Chart: Fund Source (Doughnut)
            new Chart(document.getElementById('chartFundSource'), {
                type: 'doughnut',
                data: {
                    labels: @json($labelsFundSource),
                    datasets: [{
                        label: 'Jumlah Barang',
                        data: @json($dataFundSource),
                        backgroundColor: generateColors(@json(count($dataFundSource)))
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: { display: true, text: 'Jumlah Barang Berdasarkan Sumber Dana (Doughnut_Chart)' }
                    }
                }
            });

            // Chart: Tahun (Line)
            new Chart(document.getElementById('chartTahun'), {
                type: 'line',
                data: {
                    labels: @json($labelsTahun),
                    datasets: [{
                        label: 'Jumlah Barang',
                        data: @json($dataTahun),
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: { display: true, text: 'Barang per Tahun (Line_Chart)' }
                    },
                    scales: {
                        y: { beginAtZero: true, precision: 0 }
                    }
                }
            });

            // Chart: Status (Bar)
            new Chart(document.getElementById('chartStatus'), {
                type: 'bar',
                data: {
                    labels: @json($labelsStatus),
                    datasets: [{
                        label: 'Jumlah Barang',
                        data: @json($dataStatus),
                        backgroundColor: generateColors(@json(count($dataStatus)))
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: { display: true, text: 'Jumlah Barang Berdasarkan Status (Bar_Chart)' },
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true, precision: 0 }
                    }
                }
            });
        });
    </script>
@endsection