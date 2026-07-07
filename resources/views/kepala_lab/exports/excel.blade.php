<table>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Laboratorium</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Foto</th>
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
            <td>
                @if($data->foto)
                    {{ Storage::disk('public')->url($data->foto) }}
                @else
                    Tidak ada foto
                @endif
            </td>
            <td>{{ $data->jenis_kerusakan }}</td>
            <td>{{ $data->peralatan->kondisi ?? $data->status }}</td>
            <td>{{ $data->deskripsi }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="9">Tidak ada laporan.</td>
        </tr>
    @endforelse
</table>
