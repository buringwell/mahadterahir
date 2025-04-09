<h1>Daftar Berita</h1>
    <a href="{{ route('berita.create') }}" class="btn btn-primary">Tambah Berita</a>
    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Tanggal Publikasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($beritas as $berita)
                <tr>
                    <td>{{ $berita->judul }}</td>
                    <td>{{ $berita->kategori }}</td>
                    <td>{{ $berita->penulis }}</td>
                    <td>{{ $berita->tanggal_publikasi->format('d M Y') }}</td>
                    <td>{{ ucfirst($berita->status) }}</td>
                    <td>
                        <a href="{{ route('berita.show', $berita->id) }}" class="btn btn-info">Lihat</a>
                        <a href="{{ route('berita.edit', $berita->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('berita.destroy', $berita->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>