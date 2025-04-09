<?php

namespace App\Http\Controllers;

use App\Models\petugaspembayaran;
use App\Models\User;
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
    
    
}
