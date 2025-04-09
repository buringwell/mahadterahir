<?php

namespace App\Http\Controllers;

use App\Models\presensi;
use App\Models\santri;
use App\Models\kamar;
use App\Models\kelas;
use Illuminate\Http\Request;

class absensicontroller extends Controller
{
  // 📌 Tampilkan daftar absensi
  public function index(Request $request)
  {
      $kelasId = $request->input('kelas_id');
      $kamarId = $request->input('kamar_id');
  
      // Query dasar presensi dengan relasi santri dan user
      $query = Presensi::with(['santri.user', 'santri.kelas', 'santri.kamar']);
  
      // Filter berdasarkan kelas_id
      if ($kelasId) {
          $query->whereHas('santri', function ($q) use ($kelasId) {
              $q->where('kelas_id', $kelasId);
          });
      }
  
      // Filter berdasarkan kamar_id
      if ($kamarId) {
          $query->whereHas('santri', function ($q) use ($kamarId) {
              $q->where('kamar_id', $kamarId);
          });
      }
  
      // Ambil hasil
      $absensis = $query->get();
  
      // Ambil opsi kelas & kamar dari tabel masing-masing
      $kelasOptions = kelas::pluck('nama', 'id');
      $kamarOptions = kamar::pluck('nama', 'id');
  
      return view('absensi.index', compact('absensis', 'kelasOptions', 'kamarOptions'));
  }

  
  public function create()
  {
      $santris = Santri::all(); // Ambil semua santri
      return view('absensi.create', compact('santris'));
  }
  

  public function store(Request $request)
  {
      
      $request->validate([
          'status' => 'required|array', 
          'status.*' => 'in:hadir,izin,sakit,alfa', 
          'keterangan' => 'nullable|array', 
          'keterangan.*' => 'nullable|string|max:255',
      ]);
  
      // Simpan absensi ke database
      foreach ($request->input('status', []) as $santri_id => $status) {
          Presensi::create([
              'santri_id' => $santri_id,
              'tanggal' => now(), // Set tanggal otomatis ke hari ini
              'status' => $status, // Sesuai dengan tabel
              'keterangan' => $request->input("keterangan.$santri_id"), // Ambil keterangan berdasarkan santri_id
          ]);
      }
  
      return redirect()->route('absensi.index')->with('success', 'Absensi berhasil ditambahkan!');
  }
  
  
  

  // 📌 Tampilkan form edit
  public function edit($id)
  {
      $absensi = presensi::findOrFail($id);
      $santris = Santri::all();
      return view('absensi.edit', compact('absensi', 'santris'));
  }

  // 📌 Update absensi
  public function update(Request $request, $id)
  {
      $request->validate([
          'santri_id' => 'required|exists:santris,id',
          'tanggal' => 'required|date',
          'status_kehadiran' => 'required|in:hadir,izin,sakit,alfa',
          'keterangan' => 'nullable|string',
      ]);

      $absensi = presensi::findOrFail($id);
      $absensi->update($request->all());

      return redirect()->route('absensi.index')->with('success', 'Absensi berhasil diperbarui!');
  }

  // 📌 Hapus absensi
  public function destroy($id)
  {
      $absensi = presensi::findOrFail($id);
      $absensi->delete();

      return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dihapus!');
  }
}
