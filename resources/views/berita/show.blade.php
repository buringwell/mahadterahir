<h1>{{ $berita->judul }}</h1>
    <p><strong>Kategori:</strong> {{ $berita->kategori }}</p>
    <p><strong>Penulis:</strong> {{ $berita->penulis }}</p>
    <p><strong>Tanggal Publikasi:</strong> {{ $berita->tanggal_publikasi->format('d M Y') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($berita->status) }}</p>
    <p><strong>Isi:</strong> {{ $berita->isi }}</p>
    @if ($berita->gambar)
        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Berita" width="300">
    @endif
    <a href="{{ route('berita.index') }}" class="btn btn-secondary">Kembali</a>