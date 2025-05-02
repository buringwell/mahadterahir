<?php

namespace App\Http\Controllers;

use App\Models\petugaspembayaran;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Illuminate\Http\Request;

class PetgsPembayaranControler extends Controller
{
    public function index()
    {
        $petugas = PetugasPembayaran::with('user')->get();
        return view('petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('petugas.create');
    }
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|min:10|max:15',
        ]);
    
        // Simpan User
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => 'petugas'
        ]);
    
        // Simpan Petugas Pembayaran
        PetugasPembayaran::create([
            'user_id' => $user->id,
            'alamat' => $request->input('alamat'),
            'no_hp' => $request->input('no_hp'),
        ]);
    
        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $petugas = PetugasPembayaran::findOrFail($id);
        return view('petugas.update', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
        ]);
    
        // Cari Petugas berdasarkan ID
        $petugas = PetugasPembayaran::findOrFail($id);
        
        // Update User terkait
        $user = User::findOrFail($petugas->user_id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password') ? bcrypt($request->input('password')) : $user->password,
        ]);
    
        // Update Data Petugas
        $petugas->update([
            'alamat' => $request->input('alamat'),
            'no_hp' => $request->input('no_hp'),
        ]);
    
        return redirect()->route('petugas.index')->with('success', 'Data Petugas berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        // Cari petugas berdasarkan ID
        $petugas = PetugasPembayaran::findOrFail($id);
    
        // Hapus user terkait
        $user = User::findOrFail($petugas->user_id);
        $user->delete();
    
        // Hapus petugas
        $petugas->delete();
    
        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil dihapus!');
    }
    


public function exportPetugasExcel()
{
    $petugas = PetugasPembayaran::with('user')->get();
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Nama');
    $sheet->setCellValue('C1', 'Email');
    $sheet->setCellValue('D1', 'Alamat');
    $sheet->setCellValue('E1', 'No Hp');

    // Data
    $row = 2;
    $no = 1;
    foreach ($petugas as $data) {
        $sheet->setCellValue('A' . $row, $no++);
        $sheet->setCellValue('B' . $row, $data->user->name ?? '-');
        $sheet->setCellValue('C' . $row, $data->user->email ?? '-');
        $sheet->setCellValue('D' . $row, $data->alamat ?? '-'); // dari PetugasPembayaran
        $sheet->setCellValue('E' . $row, $data->no_hp ?? '-');   // dari PetugasPembayaran
        $row++;
    }
    

    $writer = new Xlsx($spreadsheet);
    $filename = 'data_petugas.xlsx';

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $filename);
    }

    
}
