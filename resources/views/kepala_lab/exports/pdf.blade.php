<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kerusakan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #111111;
        }

        h1 {
            color: #004499;
            margin-bottom: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }

        th,
        td {
            border: 1px solid #999999;
            padding: 8px;
            font-size: 12px;
            text-align: left;
        }

        th {
            background: #004499;
            color: #ffffff;
        }

        .print-button {
            border: 0;
            border-radius: 6px;
            padding: 10px 14px;
            background: #cc9933;
            color: #ffffff;
            cursor: pointer;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">Cetak / Simpan PDF</button>

    <h1>Laporan Kerusakan Laboratorium</h1>
    <p>Dicetak pada {{ now()->format('d-m-Y H:i') }}</p>

    <table>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Laboratorium</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Deskripsi</th>
        </tr>

        @forelse($kerusakan as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->tanggal }}</td>
                <td>{{ $data->user->lokasi_lab ?? '-' }}</td>
                <td>{{ $data->peralatan->kode_barang }}</td>
                <td>{{ $data->peralatan->nama_barang }}</td>
                <td>{{ $data->jenis_kerusakan }}</td>
                <td>{{ $data->status }}</td>
                <td>{{ $data->deskripsi }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8">Tidak ada laporan.</td>
            </tr>
        @endforelse
    </table>
</body>
</html>
