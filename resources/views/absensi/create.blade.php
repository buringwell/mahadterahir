<div class="container">
    <h2>Tambah Absensi</h2>
    <form action="{{ route('absensi.store') }}" method="POST">
        @csrf

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Santri</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alfa</th>
                    <th>keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($santris as $santri)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $santri->user->name }}</td>
                    
                    <td>
                        <input type="radio" name="status[{{ $santri->id }}]" value="hadir" required>
                    </td>
                    <td>
                        <input type="radio" name="status[{{ $santri->id }}]" value="izin">
                    </td>
                    <td>
                        <input type="radio" name="status[{{ $santri->id }}]" value="sakit">
                    </td>
                    <td>
                        <input type="radio" name="status[{{ $santri->id }}]" value="alfa">
                    </td>
                    <td>
                        <input type="text" name="keterangan[{{ $santri->id }}]" class="form-control" placeholder="Masukkan keterangan (opsional)">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Simpan Absensi</button>
    </form>
</div>
