
<div class="container">
    <h2>Edit Santri</h2>
    
    <form action="{{ route('santri.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="mb-3">
            <label class="form-label">No Induk Santri</label>
            <input type="text" name="no_induk_santri" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">NIS</label>
            <input type="text" name="nis" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control"  required>
        </div>
        <div class="mb-3">
            <label class="form-label">email</label>
            <input type="email" name="email" class="form-control"  required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kelas Sekolah</label>
            <input type="text" name="kelas_sekolah" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control"  required>
        </div>
        <div class="mb-3">
            <label class="form-label">no_hp</label>
            <input type="text" name="no_hp" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">nama ayah</label>
            <input type="text" name="nama_ayah" class="form-control"  required>
        </div>
        <div class="mb-3">
            <label class="form-label">nama ibu</label>
            <input type="text" name="nama_ibu" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">nama wali</label>
            <input type="text" name="nama_wali" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">waktu_masuk</label>
            <input type="time" name="waktu_masuk" class="form-control"  required>
        </div>
        <div class="mb-3">
            <label class="form-label">waktu_keluar</label>
            <input type="time" name="waktu_keluar" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">tanggal_daftar</label>
            <input type="date" name="tanggal_daftar" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">file_foto</label>
            <input type="file" name="file_foto" class="form-control"  required>
        </div>
        <div class="mb-3">
            <label class="form-label">daftar_ulang</label>
            <input type="text" name="daftar_ulang" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">tambah</button>
    </form>
</div>

