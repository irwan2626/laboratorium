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
