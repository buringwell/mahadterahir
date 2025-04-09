<?php

namespace App\Http\Controllers;

use App\Models\Ustad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UstadController extends Controller
{
    // Menampilkan daftar Ustad
    public function index()
    {
        $ustads = Ustad::with('user')->get();
        return view('ustad.index', compact('ustads'));
    }
    

    // Menampilkan form tambah Ustad
    public function create()
    {
        return view('ustad.create');
    }

    // Menyimpan data Ustad baru
    public function store(Request $request)
    {
            $id = mt_rand(1000000000000000, 9999999999999999);

            // Simpan user terlebih dahulu
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role' => 'ustadz',
            ]);
        
            // Simpan data ustadz
            $data = [
                'ustadz_id' => $id,
                'user_id' => $user->id, // Hubungkan ke user
                'JK' => $request->input('JK'),
                'No_Hp' => $request->input('No_Hp'),
                'alamat' => $request->input('alamat'),
                'mata_pelajaran' => $request->input('mata_pelajaran'),
            ];
        
        
            Ustad::create($data);
        
            return redirect()->route('ustadz.index')->with('success', 'Data ustadz berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        $ustadz = Ustad::findOrFail($id);
        return view('ustad.edit', compact('ustadz'));
    }
    
    public function update(Request $request, $id)
    {
        $ustadz = Ustad::findOrFail($id);
        $user = User::findOrFail($ustadz->user_id); // Ambil user yang terkait
    
        // Update user
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password') ? Hash::make($request->input('password')) : $user->password,
        ]);
    
        // Update data ustadz
        $data = [
            'JK' => $request->input('JK'),
            'No_Hp' => $request->input('No_Hp'),
            'alamat' => $request->input('alamat'),
            'mata_pelajaran' => $request->input('mata_pelajaran'),
        ];
    
    
        $ustadz->update($data);
    
        return redirect()->route('ustadz.index')->with('success', 'Data ustadz berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $ustadz = Ustad::findOrFail($id);
        $user = User::findOrFail($ustadz->user_id);
    
        // Hapus data ustadz dan user terkait
        $ustadz->delete();
        $user->delete();
    
        return redirect()->route('ustadz.index')->with('success', 'Data ustadz berhasil dihapus!');
    }
    
}
