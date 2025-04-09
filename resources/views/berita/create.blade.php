<h1>Tambah Berita Baru</h1>
    <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="judul">Judul:</label>
            <input type="text" name="judul" id="judul" required>
        </div>
        <div>
            <label for="isi">Isi:</label>
            <textarea name="isi" id="isi" required></textarea>
        </div>
        <div>
            <label for="kategori">Kategori:</label>
            <input type="text" name="kategori" id="kategori" required>
        </div>
        <div>
            <label for="tanggal_publikasi">Tanggal Publikasi:</label>
            <input type="date" name="tanggal_publikasi" id="tanggal_publikasi" required>
        </div>
        <div>
            <label for="penulis">Penulis:</label>
            <input type="text" name="penulis" id="penulis" required>
        </div>
        <div>
            <label for="gambar">Gambar:</label>
            <input type="file" name="gambar" id="gambar">
        </div>
        <div>
            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="draft">Draft</option>
                <option value="terbit">Terbit</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>