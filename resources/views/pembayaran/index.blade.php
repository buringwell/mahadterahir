
<div class="container">
    <h2>Daftar Pembayaran</h2>
    
    <!-- Alert jika ada notifikasi sukses -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('pembayaran.create') }}" class="btn btn-primary mb-3">Tambah Pembayaran</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Santri</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Kode Transaksi</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembayarans as $index => $pembayaran)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pembayaran->santri->user->name ?? 'Tidak Diketahui' }}</td> <!-- ✅ Ambil nama dari user -->
                <td>Rp {{ number_format($pembayaran->jumlah, 2, ',', '.') }}</td>
                <td>{{ date('d M Y', strtotime($pembayaran->tanggal)) }}</td>
                <td>{{ $pembayaran->kode_transaksi }}</td>
                <td>{{ ucfirst($pembayaran->metode_pembayaran) }}</td>
                <td>
                    <span class="badge 
                        {{ $pembayaran->status_pembayaran == 'pending' ? 'bg-warning' : ($pembayaran->status_pembayaran == 'lunas' ? 'bg-success' : 'bg-danger') }}">
                        {{ ucfirst($pembayaran->status_pembayaran) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('pembayaran.edit', $pembayaran->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    
                    <form action="{{ route('pembayaran.destroy', $pembayaran->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

