
   <h2>Daftar Ustad</h2>
    <a href="{{ route('ustadz.create') }}">Tambah Ustad</a>
    <a href="{{ route('ustad.export') }}" class="btn btn-success mb-3">Export Excel</a>
    <form action="{{ route('ustad.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Import</button>
    </form>
    
    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>JK</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th>Mata Pelajaran</th>
            <th>Aksi</th>
        </tr>
        @foreach($ustads as $ustad)
            <tr>
                <td>{{ $ustad->user->name }}</td>
                <td>{{ $ustad->user->email }}</td>
                <td>{{ $ustad->JK }}</td>
                <td>{{ $ustad->No_HP }}</td>
                <td>{{ $ustad->alamat }}</td>
                <td>{{ $ustad->mata_pelajaran }}</td>
                <td>
                    <a href="{{ route('ustadz.edit', $ustad->id) }}">Edit</a>
                    <form action="{{ route('ustadz.destroy', $ustad->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

