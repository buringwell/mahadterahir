

<div class="container">
    <h2>Daftar Kamar</h2>
    <a href="{{ route('kamar.create') }}" class="btn btn-primary mb-3">Tambah Kamar</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kamarss as $k)
                <tr>
                    <td>{{ $k->nama }}</td>
                    <td>
                        <a href="{{ route('kamar.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('kamar.destroy', $k->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
