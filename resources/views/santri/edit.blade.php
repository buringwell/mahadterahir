
<div class="container">
    <h2>Edit Santri</h2>
    
    <form action="{{ route('santri.update', $santri->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- User Fields -->
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $santri->user->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $santri->user->email }}" required>
        </div>

        <!-- Santri Fields -->
        <div class="mb-3">
            <label class="form-label">No Induk Santri</label>
            <input type="text" name="no_induk_santri" class="form-control" value="{{ $santri->no_induk_santri }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">NIS</label>
            <input type="text" name="nis" class="form-control" value="{{ $santri->nis }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kelas Sekolah</label>
            <input type="text" name="kelas_sekolah" class="form-control" value="{{ $santri->kelas_sekolah }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ $santri->alamat }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" value="{{ $santri->tanggal_lahir }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">No HP</label>
            <input type="text" name="no_hp" class="form-control" value="{{ $santri->no_hp }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Ayah</label>
            <input type="text" name="nama_ayah" class="form-control" value="{{ $santri->nama_ayah }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Ibu</label>
            <input type="text" name="nama_ibu" class="form-control" value="{{ $santri->nama_ibu }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Wali</label>
            <input type="text" name="nama_wali" class="form-control" value="{{ $santri->nama_wali }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Waktu Masuk</label>
            <input type="time" name="waktu_masuk" class="form-control" value="{{ $santri->waktu_masuk }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Waktu Keluar</label>
            <input type="time" name="waktu_keluar" class="form-control" value="{{ $santri->waktu_keluar }}" required>
        </div>

        <!-- SantriDetail Fields -->
        <div class="mb-3">
            <label class="form-label">Tanggal Daftar</label>
            <input type="date" name="tanggal_daftar" class="form-control" value="{{ $santri->santriDetail->tanggal_daftar }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">File Foto</label>
            <input type="file" name="file_foto" class="form-control">
            @if ($santri->santriDetail->file_foto)
                <p>Current Photo: <a href="{{ asset('storage/' . $santri->santriDetail->file_foto) }}" target="_blank">View Photo</a></p>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Daftar Ulang</label>
            <select name="daftar_ulang" class="form-control" required>
                <option value="1" {{ $santri->santriDetail->daftar_ulang ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$santri->santriDetail->daftar_ulang ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
