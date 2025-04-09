<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{ public function index()
    {
        $beritas = Berita::latest()->get(); // Ambil semua data berita, diurutkan dari yang terbaru
        return view('berita.index', compact('beritas')); // Tampilkan view dengan data berita
    }

    public function create()
    {
        return view('berita.create'); // Tampilkan form create
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|string|max:255',
            'tanggal_publikasi' => 'required|date',
            'penulis' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk file gambar
            'status' => 'required|in:draft,terbit',
        ]);

        // Simpan file gambar jika ada
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('gambar_berita', 'public');
        }

        // Simpan data berita
        Berita::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori' => $request->kategori,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'penulis' => $request->penulis,
            'gambar' => $gambarPath,
            'status' => $request->status,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function show($id)
    {
        $berita = Berita::findOrFail($id); // Ambil data berita berdasarkan ID
        return view('berita.show', compact('berita')); // Tampilkan view detail
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id); // Ambil data berita berdasarkan ID
        return view('berita.edit', compact('berita')); // Tampilkan form edit
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|string|max:255',
            'tanggal_publikasi' => 'required|date',
            'penulis' => 'required|string|max:255',
            'gambar' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048', // Contoh validasi untuk file gambar
            'status' => 'required|in:draft,terbit',
        ]);

        $berita = Berita::findOrFail($id); // Ambil data berita berdasarkan ID

        // Update file gambar jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($berita->gambar) {
                Storage::delete($berita->gambar);
            }
            $gambarPath = $request->file('gambar')->store('public/gambar_berita');
            $berita->gambar = file_get_contents($request->file('gambar')->getRealPath());
        }

        // Update data berita
        $berita->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori' => $request->kategori,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'penulis' => $request->penulis,
            'status' => $request->status,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id); // Ambil data berita berdasarkan ID

        // Hapus gambar jika ada
        if ($berita->gambar) {
            Storage::delete($berita->gambar);
        }

        $berita->delete(); // Hapus data berita
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}