<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;


class KelasController extends Controller
{
    public function index()
    {
        $kelass = Kelas::all();
        return view('kelas.index', compact('kelass'));
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|in:7,8,9'
        ]);
        Kelas::create($request->only('nama', 'tingkat'));
        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kelas)
    {
        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|in:7,8,9'
        ]);
        $kelas->update($request->only('nama', 'tingkat'));
        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diupdate.');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}