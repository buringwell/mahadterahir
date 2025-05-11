<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\detail;
use App\Models\santri;
use App\Models\SantriDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Kelas;
use App\Models\Kamar;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;




class santricontroller extends Controller
{
    public function index()
    {
        $santris = Santri::with(['user', 'santriDetail', 'kelas', 'kamar'])
    ->whereHas('user', function ($query) {
        $query->where('role', 'santri'); // ganti sesuai kolom role di tabel users
    })
    ->get();
    return view('santri.index', compact('santris'));
        
    }
    
    
    public function create()
    {
        return view('santri.create');
    }
    public function store(Request $request)
    {
        
        // Simpan User
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => 'santri'
        ]);
    
        // Simpan Santri
        $santri = Santri::create([
            'user_id' => $user->id,
            'no_induk_santri' => $request->input('no_induk_santri'),
            'nis' => $request->input('nis'),
            'kelas_sekolah' => $request->input('kelas_sekolah'),
            'alamat' => $request->input('alamat'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'no_hp' => $request->input('no_hp'),
            'nama_ayah' => $request->input('nama_ayah'),
            'nama_ibu' => $request->input('nama_ibu'),
            'nama_wali' => $request->input('nama_wali'),
            'status' => 'aktif',
            'waktu_masuk' => $request->input('waktu_masuk'),
            'waktu_keluar' => $request->input('waktu_keluar'),
        ]);

    
        // Upload Foto Santri (Opsional)
        if ($request->hasFile('file_foto')) {
            $path = $request->file('file_foto')->store('images/santri', 'public');
        } else {
            $path = null;
        }
      
        // Simpan ke Santri Detail
        SantriDetail::create([
            'santri_id' =>$santri->id,
            'tanggal_daftar' => $request->input('tanggal_daftar'), // Pastikan format Y-m-d
            'file_foto' => $path,
            'daftar_ulang' => (bool) $request->input('daftar_ulang', false), // Konversi ke boolean
            'status' => 'aktif', // Pastikan nilai sesuai enum
        ]);

        return redirect()->route('santri.index')->with('success', 'Santri berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        $santri = santri::findOrFail($id);
        return view('santri.edit', compact('santri'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'no_induk_santri' => 'required',
            'nis' => 'required',
            'kelas_sekolah' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'nama_wali' => 'required',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'tanggal_daftar' => 'required|date',
            'file_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'daftar_ulang' => 'required|boolean',
        ]);
    
        // Find the Santri
        $santri = Santri::findOrFail($id);
    
        // Update User
        $santri->user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
    
        // Update Santri
        $santri->update([
            'no_induk_santri' => $request->input('no_induk_santri'),
            'nis' => $request->input('nis'),
            'kelas_sekolah' => $request->input('kelas_sekolah'),
            'alamat' => $request->input('alamat'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'no_hp' => $request->input('no_hp'),
            'nama_ayah' => $request->input('nama_ayah'),
            'nama_ibu' => $request->input('nama_ibu'),
            'nama_wali' => $request->input('nama_wali'),
            'waktu_masuk' => $request->input('waktu_masuk'),
            'waktu_keluar' => $request->input('waktu_keluar'),
        ]);
    
        // Update SantriDetail
        $santriDetail = $santri->santriDetail;
        $santriDetail->update([
            'tanggal_daftar' => $request->input('tanggal_daftar'),
            'daftar_ulang' => $request->input('daftar_ulang'),
        ]);
    
        // Handle file upload
        if ($request->hasFile('file_foto')) {
            $path = $request->file('file_foto')->store('images/santri', 'public');
            $santriDetail->file_foto = $path;
            $santriDetail->save();
        }
    
        return redirect()->route('santri.index')->with('success', 'Santri updated successfully!');
    }

    public function destroy($id)
    {
        // Mulai transaksi database
        DB::transaction(function () use ($id) {

            $santri = Santri::findOrFail($id);

            $user = User::findOrFail($santri->user_id);

            $santriDetail = SantriDetail::where('santri_id', $santri->id)->first();
            if ($santriDetail) {
                $santriDetail->delete();
            }

            $santri->delete();
            $user->delete();
        });
        return redirect()->route('santri.index')->with('success', 'Data santri berhasil dihapus!');
}




public function export()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set Header Kolom
    // Header
    $headers = [
        'No', 'no_induk_santri', 'nis', 'nama', 'email', 'kelas', 'kamar',
        'alamat', 'tanggal_lahir', 'no_hp', 'nama_ayah', 'nama_ibu', 'nama_wali',
        'status', 'waktu_masuk', 'waktu_keluar'
    ];
    $sheet->fromArray($headers, null, 'A1');

 

    // Ambil data santri
    $santris = Santri::with(['user', 'santriDetail', 'kelas', 'kamar'])
    ->whereHas('user', function ($query) {
        $query->where('role', 'santri'); // ganti sesuai kolom role di tabel users
    })
    ->get();

    // Data
   
    // Data
    $row = 2;
    $no = 1;
    foreach ($santris as $santri) {
        $detail = $santri->santriDetail;
        $sheet->setCellValue('A' . $row, $no++);
        $sheet->setCellValue('B' . $row, $santri->no_induk_santri);
        $sheet->setCellValue('C' . $row, $santri->nis);
        $sheet->setCellValue('D' . $row, $santri->user->name ?? '');
        $sheet->setCellValue('E' . $row, $santri->user->email ?? '');
        $sheet->setCellValue('F' . $row, $santri->kelas_id);
        $sheet->setCellValue('G' . $row, $santri->kamar_id);
        $sheet->setCellValue('H' . $row, $santri->alamat ?? '');
        $sheet->setCellValue('I' . $row, $santri->tanggal_lahir ?? '');
        $sheet->setCellValue('J' . $row, $santri->no_hp ?? '');
        $sheet->setCellValue('K' . $row, $santri->nama_ayah ?? '');
        $sheet->setCellValue('L' . $row, $santri->nama_ibu ?? '');
        $sheet->setCellValue('M' . $row, $santri->nama_wali ?? '');
        $sheet->setCellValue('N' . $row, $detail->status ?? '');
        $sheet->setCellValue('O' . $row, $santri->waktu_masuk ?? '');
        $sheet->setCellValue('P' . $row, $santri->waktu_keluar ?? '');
        $row++;
    }

    // Buat nama file
    $fileName = 'data_santri.xlsx';

    // Output ke browser
    $writer = new Xlsx($spreadsheet);
    $temp_file = tempnam(sys_get_temp_dir(), $fileName);
    $writer->save($temp_file);

    return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }




    public function import(Request $request)
    {
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
    
        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                if ($index === 0) continue; // Skip header
    
                $no_induk_santri = $row[1] ?? null;
                $nis             = $row[2] ?? null;
                $nama            = $row[3] ?? null;
                $email           = $row[4] ?? null;
                $kelas_id = (int) ($row[5] ?? 0);
                $kamar_id = (int) ($row[6] ?? 0);
                $alamat          = $row[7] ?? null;

                // Misal $row[8] adalah kolom tanggal lahir
                
                $tanggalExcel = $row[8] ?? null;

                if (is_numeric($tanggalExcel)) {
                    // Format Excel (numeric), ubah jadi Carbon
                    $tanggal_lahir = Date::excelToDateTimeObject($tanggalExcel)->format('Y-m-d');
                } else {
                    // Format string, langsung coba parse
                    $tanggal_lahir = Carbon::parse($tanggalExcel)->format('Y-m-d');
                }
                
                $no_hp           = $row[9] ?? null; 
                $nama_ayah       = $row[10] ?? null;
                $nama_ibu        = $row[11] ?? null;
                $nama_wali       = $row[12] ?? null;
                $status          = $row[13] ?? null;
                $tanggal_daftar  = $row[14] ?? null;
                if (is_numeric($tanggal_daftar)) {
                    $tanggal_daftar = Date::excelToDateTimeObject($tanggal_daftar)->format('Y-m-d');
                } else {
                    $tanggal_daftar = Carbon::parse($tanggal_daftar)->format('Y-m-d');
                }

                $waktu_masuk     = $row[15] ?? null;
                $waktu_keluar    = $row[16] ?? null;

    
 
                // Buat atau ambil user
                $user = User::firstOrCreate(
                    ['email' => $email],
                    ['name' => $nama, 'password' => bcrypt('santri123'), 'role' => 'santri']
                );

                // Cek / buat kelas
            $kelas = Kelas::firstOrCreate([
                'id' => $kelas_id
            ]);

            // Cek / buat kamar
            $kamar = Kamar::firstOrCreate(['id' => $kamar_id]);
    
                // Buat data santri
                $santri = Santri::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'no_induk_santri' => $no_induk_santri,
                        'nis'=> $nis,
                        'kelas_id'        => $kelas->id,
                        'kamar_id'        => $kamar->id,
                        'alamat'          => $alamat,
                        'tanggal_lahir'   => $tanggal_lahir,
                        'no_hp'           => $no_hp,
                        'nama_ayah'       => $nama_ayah,
                        'nama_ibu'        => $nama_ibu,
                        'nama_wali'       => $nama_wali,
                        'status'          => $status,
                        'waktu_masuk'     => $waktu_masuk,
                        'waktu_keluar'    => $waktu_keluar,
                    ]
                );
    
                // Detail santri
                SantriDetail::updateOrCreate(
                    ['santri_id' => $santri->id],
                    [
                        'staus' => $status,
                        'tanggal_daftar' => $tanggal_daftar
                    ]
                );
            }
    
            DB::commit();
            return back()->with('success', 'Import santri berhasil!');
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e; // sementara, agar muncul error jelas
        
        }
    }
    

}
