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
      $tingkat = $request->input('tingkat');
      $kelasSekolah = $request->input('kelas_sekolah');
      $kamar = $request->input('kamar');
  
      $query = presensi::with('santri.user');
  
      if ($tingkat) {
          $query->whereHas('santri.kelas', function ($q) use ($tingkat) {
              $q->where('tingkat', $tingkat);
          });
      }
  
      if ($kelasSekolah) {
          $query->whereHas('santri', function ($q) use ($kelasSekolah) {
              $q->where('kelas_id', $kelasSekolah); // Pastikan filter berdasarkan ID
          });
      }
  
      if ($kamar) {
          $query->whereHas('santri', function ($q) use ($kamar) {
              $q->where('kamar_id', $kamar); // Filter berdasarkan ID kamar
          });
      }
  
      $absensis = $query->get();
  
      // Ambil pilihan filter
      $kelasOptions = Kelas::pluck('nama', 'id');
      $kamarOptions = Kamar::pluck('nama', 'id');
      $tingkatOptions = Kelas::distinct()->pluck('tingkat');
  
      return view('absensi.index', compact('absensis', 'kelasOptions', 'kamarOptions', 'tingkatOptions'));
  }
  
  
  public function create(Request $request)
  {
      $tingkat = $request->input('tingkat');
      $kelasId = $request->input('kelas_sekolah');
      $kamarId = $request->input('kamar');
  
      $query = Santri::with('user');
  
      if ($tingkat) {
          $query->whereHas('kelas', function ($q) use ($tingkat) {
              $q->where('tingkat', $tingkat);
          });
      }
  
      if ($kelasId) {
          $query->where('kelas_id', $kelasId);
      }
  
      if ($kamarId) {
          $query->where('kamar_id', $kamarId);
      }
  
      $santris = $query->get();
  
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
      return view('absensi.update', compact('absensi', 'santris'));
  }

  // 📌 Update absensi
  public function update(Request $request, $id)
  {
      $request->validate([
          'santri_id' => 'required|exists:santris,id',
          'tanggal' => 'required|date',
          'status' => 'required|in:hadir,izin,sakit,alfa',
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
