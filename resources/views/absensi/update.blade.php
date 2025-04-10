<div class="container">
    <h1>Edit Absensi</h1>
    <form action="{{ route('absensi.update', $absensi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Input Santri -->
        <div class="form-group">
            <label for="santri_id">Santri</label>
            <select name="santri_id" id="santri_id" class="form-control" required>
                <option value="">Pilih Santri</option>
                @foreach($santris as $santri)
                    <option value="{{ $santri->id }}" {{ $absensi->santri_id == $santri->id ? 'selected' : '' }}>
                        {{ $santri->user->name }}
                    </option>
                @endforeach
            </select>
            @error('santri_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Input Tanggal -->
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $absensi->tanggal) }}" required>
            @error('tanggal')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tabel Status Kehadiran -->
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Santri</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alfa</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $absensi->santri->user->name }}</td>
                    <td>
                        <input type="radio" name="status" value="hadir" {{ $absensi->status === 'hadir' ? 'checked' : '' }} required>
                    </td>
                    <td>
                        <input type="radio" name="status" value="izin" {{ $absensi->status === 'izin' ? 'checked' : '' }}>
                    </td>
                    <td>
                        <input type="radio" name="status" value="sakit" {{ $absensi->status === 'sakit' ? 'checked' : '' }}>
                    </td>
                    <td>
                        <input type="radio" name="status" value="alfa" {{ $absensi->status === 'alfa' ? 'checked' : '' }}>
                    </td>
                    <td>
                        <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan', $absensi->keterangan) }}" placeholder="Masukkan keterangan (opsional)">
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>