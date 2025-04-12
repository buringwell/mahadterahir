<?php

namespace App\Http\Controllers;

use App\Models\presensi;
use App\Models\santri;
use App\Models\kamar;
use App\Models\kelas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        public function rekapSemester(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $semester = $request->input('semester', 1);

        $startMonth = $semester == 1 ? 1 : 7;
        $endMonth = $semester == 1 ? 6 : 12;

        $rekap = DB::table('presensis')
            ->select('santri_id',
                DB::raw("SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as hadir"),
                DB::raw("SUM(CASE WHEN status = 'izin' THEN 1 ELSE 0 END) as izin"),
                DB::raw("SUM(CASE WHEN status = 'sakit' THEN 1 ELSE 0 END) as sakit"),
                DB::raw("SUM(CASE WHEN status = 'alfa' THEN 1 ELSE 0 END) as alfa")
            )
            ->whereYear('tanggal', $tahun)
            ->whereBetween(DB::raw('MONTH(tanggal)'), [$startMonth, $endMonth])
            ->groupBy('santri_id')
            ->get();

        $santriIds = $rekap->pluck('santri_id');
        $santris = \App\Models\Santri::whereIn('id', $santriIds)->with('user')->get()->keyBy('id');

        return view('absensi.rekap_semester', compact('rekap', 'santris', 'semester', 'tahun'));
    }

    public function rekap(Request $request)
{
    $bulan = $request->input('bulan', now()->month);
    $tahun = $request->input('tahun', now()->year);
    $kelasId = $request->input('kelas_id');
    $kamarId = $request->input('kamar_id');

    $query = Presensi::with('santri.user');

    $semester = $request->input('semester');
    $bulan = $request->input('bulan');
    $tahun = $request->input('tahun', now()->year);

    $query = Presensi::with('santri.user');

    if ($semester) {
        // Semester 1: Januari - Juni | Semester 2: Juli - Desember
        $startMonth = $semester == 1 ? 1 : 7;
        $endMonth = $semester == 1 ? 6 : 12;

        $query->whereMonth('tanggal', '>=', $startMonth)
              ->whereMonth('tanggal', '<=', $endMonth)
              ->whereYear('tanggal', $tahun);
    }

    if ($bulan) {
        $query->whereMonth('tanggal', $bulan)
              ->whereYear('tanggal', $tahun);
    }

    // Tambahkan filter kelas, kamar, dsb sesuai kebutuhanmu

    $rekap = $query->get();


    // Filter bulan dan tahun
    $query->whereMonth('tanggal', $bulan)
          ->whereYear('tanggal', $tahun);

    // Filter kelas
    if ($kelasId) {
        $query->whereHas('santri.kelas', function ($q) use ($kelasId) {
            $q->where('id', $kelasId);
        });
    }

    // Filter kamar
    if ($kamarId) {
        $query->whereHas('santri.kamar', function ($q) use ($kamarId) {
            $q->where('id', $kamarId);
        });
    }

    $presensis = $query->get();

    // Rekap berdasarkan santri
    $rekap = $presensis->groupBy('santri_id')->map(function ($data) {
        return [
            'hadir' => $data->where('status', 'hadir')->count(),
            'izin' => $data->where('status', 'izin')->count(),
            'sakit' => $data->where('status', 'sakit')->count(),
            'alfa' => $data->where('status', 'alfa')->count(),
        ];
    });

    $santriIds = $rekap->keys();
    $santris = Santri::whereIn('id', $santriIds)->with('user')->get()->keyBy('id');

    $kelasOptions = Kelas::pluck('nama', 'id');
    $kamarOptions = Kamar::pluck('nama', 'id');

    return view('absensi.rekap_bulanan', compact(
        'rekap', 'santris', 'kelasOptions', 'kamarOptions', 'bulan', 'tahun'
    ));
    }
}
