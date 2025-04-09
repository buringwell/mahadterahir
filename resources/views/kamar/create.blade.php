

<div class="container">
    <h2>Tambah Kamar</h2>
    <form action="{{ route('kamar.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Kamar</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

