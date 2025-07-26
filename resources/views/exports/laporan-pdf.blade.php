<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan {{ $tahun }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 15px;
        }

        h1 {
            color: #2c3e50;
            font-size: 22px;
            margin-bottom: 5px;
        }

        h2 {
            color: #3498db;
            font-size: 16px;
            margin-top: 25px;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 8px 10px;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .total-row {
            font-weight: bold;
            background-color: #e8f4fc !important;
        }

        .currency {
            text-align: right;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 11px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN KEUANGAN TAHUN {{ $tahun }}
            @if($bulan && is_numeric($bulan) && $bulan >= 1 && $bulan <= 12)
                <br>BULAN {{ strtoupper(\Carbon\Carbon::create()->month((int) $bulan)->translatedFormat('F')) }}
            @endif
        </h1>
    </div>

    <h2>RINGKASAN PEMASUKAN & PENGELUARAN</h2>
    <table>
        <thead>
            <tr>
                <th width="30%">Bulan</th>
                <th width="30%">Jenis</th>
                <th width="40%" class="currency">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataBulanan as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::create()->month((int) $item->bulan)->translatedFormat('F') }}</td>
                    <td>{{ ucfirst($item->jenis) }}</td>
                    <td class="currency">Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>PENGELUARAN TERBANYAK PER KATEGORI</h2>
    <table>
        <thead>
            <tr>
                <th width="70%">Kategori</th>
                <th width="30%" class="currency">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topKategori as $item)
                <tr>
                    <td>{{ ucwords($item['nama']) }}</td>
                    <td class="currency">Rp{{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Laporan ini dibuat secara otomatis pada {{ now()->translatedFormat('d F Y H:i:s') }}
    </div>
</body>

</html>