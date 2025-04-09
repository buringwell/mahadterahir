
<div class="container">
    <h2>Tambah Kelas</h2>
    <form action="{{ route('kelas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Kelas</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tingkat</label>
            <select name="tingkat" class="form-control" required>
                <option value="">Pilih Tingkat</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

