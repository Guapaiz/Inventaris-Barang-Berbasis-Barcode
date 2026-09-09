<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan PDF</title>
    <style>
        @page {
            margin: 3cm 3cm 3cm 4cm;
        }

        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h3 {
            text-align: center;
            margin-bottom: 25px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 5px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: right;
            margin-top: 60px;
        }

        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>

    <h3>LAPORAN DATA BARANG<br>
       
        @if($start_date && $end_date)
            <p style="text-align: center; margin-top: 0;">
                Periode: {{ \Carbon\Carbon::parse($start_date)->translatedFormat('d F Y') }}
                – {{ \Carbon\Carbon::parse($end_date)->translatedFormat('d F Y') }}
            </p>
        @endif

    </h3>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Lengkap</th>
                <th>Merk</th>
                <th>Spesifikasi</th>
                <th>Kondisi</th>
                <th>Sumber Dana</th>
                <th>Tahun</th>
                <th>Tanggal Masuk</th>
                <th>Kode Barang</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($barang as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->full_name }}</td>
                    <td>{{ $item->brand_name }}</td>
                    <td>{{ $item->specification }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->fund_source }}</td>
                    <td>{{ $item->year }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->join_date)->translatedFormat('d F Y') }}</td>
                    <td>{{ $item->kode_barang }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse

            @if(count($barang) > 0)
                <tr class="total-row">
                    <td colspan="9" style="text-align: center;">Total Barang: {{ $barang->count() }}</td>
                </tr>
            @endif
        </tbody>
    </table>

</body>

</html>