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

class santricontroller extends Controller
{
    public function index()
    {
        $santris = Santri::with(['user', 'santriDetail', 'kamar' , 'kamar'])->get();
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
}
