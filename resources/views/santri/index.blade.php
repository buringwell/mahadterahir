<a href="{{ route('santri.create') }}">Tambah santri</a>
<a href="{{ route('export') }}" class="btn btn-success">Export Excel</a>
<form action="{{ route('santri.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <button type="submit">Import</button>
</form>

<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Kelas</th>
            <th>tingkat</th>
            <th>kamar</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($santris as $santri)
        <tr>
            <td>{{ $santri->user->name }}</td>
            <td>{{ $santri->user->email }}</td>
            <td>{{ $santri->kelas->nama ?? 'kososng' }}</td>
            <td>{{ $santri->kelas->tingkat ?? 'kosong' }}</td>
            <td>{{ $santri->kamar->nama ?? 'kosong' }}</td>
            <td>{{ $santri->santriDetail->alamat ?? 'kosong' }}</td>
            <td>
                <a href="{{ route('santri.edit', $santri->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('santri.edit', $santri->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('santri.destroy', $santri->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus santri ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
