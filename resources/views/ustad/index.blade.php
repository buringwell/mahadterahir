
   <h2>Daftar Ustad</h2>
    <a href="{{ route('ustadz.create') }}">Tambah Ustad</a>
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
                    <a href="{{ route('ustads.show', $ustad->id) }}">Lihat</a>
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

