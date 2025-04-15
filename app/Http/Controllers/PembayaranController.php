<?php

namespace App\Http\Controllers;

use App\Models\pembayaran;
use App\Models\pembayaran_detal;
use App\Models\santri;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with('santri.user')->get(); // ✅ Ambil data santri dan user
        return view('pembayaran.index', compact('pembayarans'));
    }
    
    public function create()
    {
        $santris = Santri::with('user')->get(); // ✅ Ambil semua santri beserta usernya
        return view('pembayaran.create', compact('santris'));
    }


    public function store(Request $request)
    {
        // Validasi Input
        $validatedData = $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'jumlah' => 'numeric|min:0|max:99999999.99',
            'tanggal' => 'required|date',
            'metode_pembayaran' => 'required|in:cash,transfer,qris,beasiswa',
            'file_transaksi' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'bulan' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);
        
    
        // Generate kode transaksi unik
        $validatedData['kode_transaksi'] = 'TRX-' . strtoupper(uniqid());
    
        // Simpan data pembayaran
        $pembayaran = Pembayaran::create($validatedData);
    
        // Simpan file transaksi jika ada
        if ($request->hasFile('file_transaksi')) {
            $path = $request->file('file_transaksi')->store('transaksi', 'public');
            pembayaran_detal::create([
                'pembayaran_id' => $pembayaran->id,
                'file_transaksi' => $path,
                'bulan_dibayar' => $request->input('bulan_dibayar'),
                'keterangan' => $request->input('keterangan'),
            ]);
        } else {
            // Tetap simpan detail meskipun tanpa file
            pembayaran_detal::create([
                'pembayaran_id' => $pembayaran->id,
                'bulan_dibayar' => $request->input('bulan_dibayar'),
                'keterangan' => $request->input('keterangan'),
            ]);
        }
    
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id); // Ambil data pembayaran berdasarkan ID
        $santris = Santri::with('user')->get(); // Ambil semua santri untuk dropdown
    
        return view('pembayaran.update', compact('pembayaran', 'santris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'jumlah' => 'numeric|min:0|max:99999999.99',
            'tanggal' => 'required|date',
            'status_pembayaran' => 'required|in:pending,lunas,gagal',
            'metode_pembayaran' => 'required|in:cash,transfer,qris,beasiswa',
        ]);
    
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update([
            'santri_id' => $request->santri_id,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'status_pembayaran' => $request->status_pembayaran,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);
    
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();
    
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus!');
    }
    
}
