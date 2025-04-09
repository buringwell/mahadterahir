<h1>Edit Berita</h1>
    <form action="{{ route('berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="judul">Judul:</label>
            <input type="text" name="judul" id="judul" value="{{ $berita->judul }}" required>
        </div>
        <div>
            <label for="isi">Isi:</label>
            <textarea name="isi" id="isi" required>{{ $berita->isi }}</textarea>
        </div>
        <div>
            <label for="kategori">Kategori:</label>
            <input type="text" name="kategori" id="kategori" value="{{ $berita->kategori }}" required>
        </div>
        <div>
            <label for="tanggal_publikasi">Tanggal Publikasi:</label>
            <input type="date" name="tanggal_publikasi" id="tanggal_publikasi" value="{{ $berita->tanggal_publikasi->format('Y-m-d') }}" required>
        </div>
        <div>
            <label for="penulis">Penulis:</label>
            <input type="text" name="penulis" id="penulis" value="{{ $berita->penulis }}" required>
        </div>
        <div>
            <label for="gambar">Gambar:</label>
            <input type="file" name="gambar" id="gambar">
            @if ($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Berita" width="100">
            @endif
        </div>
        <div>
            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="draft" {{ $berita->status == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="terbit" {{ $berita->status == 'terbit' ? 'selected' : '' }}>Terbit</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>