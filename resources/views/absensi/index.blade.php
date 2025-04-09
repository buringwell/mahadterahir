<div class="container">
    <h2>Daftar Absensi Santri</h2>
    <a href="{{ route('absensi.create') }}" class="btn btn-primary mb-3">Tambah Absensi</a>

    <select name="kelas_id" id="kelas_id" class="form-control">
        <option value="">Pilih Kelas</option>
        @foreach($kelasOptions as $id => $nama)
            <option value="{{ $id }}" {{ request('kelas_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
        @endforeach
    </select>
    
    <select name="kamar_id" id="kamar_id" class="form-control">
        <option value="">Pilih Kamar</option>
        @foreach($kamarOptions as $id => $nama)
            <option value="{{ $id }}" {{ request('kamar_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
        @endforeach
    </select>
    

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Santri</th>
                <th>Tanggal</th>
                <th>Hadir</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alfa</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensis as $presensi)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $presensi->santri->user->name }}</td>
                <td>{{ $presensi->tanggal }}</td>
                <td>
                    <input type="checkbox" disabled {{ $presensi->status == 'hadir' ? 'checked' : '' }}>
                </td>
                <td>
                    <input type="checkbox" disabled {{ $presensi->status == 'sakit' ? 'checked' : '' }}>
                </td>
                <td>
                    <input type="checkbox" disabled {{ $presensi->status == 'izin' ? 'checked' : '' }}>
                </td>
                <td>
                    <input type="checkbox" disabled {{ $presensi->status == 'alfa' ? 'checked' : '' }}>
                </td>
                <td>{{ $presensi->keterangan }}</td>
                <td>
                    <a href="{{ route('absensi.edit', $presensi->id) }}">Edit</a>
                    <form action="{{ route('absensi.destroy', $presensi->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>