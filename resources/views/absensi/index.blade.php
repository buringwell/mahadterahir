<div class="container">
    <h2>Daftar Absensi Santri</h2>
    <form method="GET" action="{{ route('absensi.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <select name="kelas_sekolah" class="form-control">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelasOptions as $id => $nama)
                        <option value="{{ $id }}" {{ request('kelas_sekolah') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
    
            <div class="col-md-3">
                <select name="kamar" class="form-control">
                    <option value="">Pilih Kamar</option>
                    @foreach($kamarOptions as $id => $nama)
                        <option value="{{ $id }}" {{ request('kamar') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
    
            <div class="col-md-3">
                <select name="tingkat" class="form-control">
                    <option value="">Pilih Tingkat</option>
                    @foreach($tingkatOptions as $tingkat)
                        <option value="{{ $tingkat }}" {{ request('tingkat') == $tingkat ? 'selected' : '' }}>
                            Kelas {{ $tingkat }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <div class="col-md-3">
                <button type="submit" class="btn btn-success">Filter</button>
            </div>
        </div>
    </form>

    <a href="{{ route('absensi.create', request()->only(['tingkat', 'kelas_sekolah', 'kamar'])) }}" class="btn btn-primary mb-3">
        Tambah Absensi
    </a>
    
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