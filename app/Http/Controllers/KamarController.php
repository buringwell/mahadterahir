<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    
        public function index()
        {
            $kamars = Kamar::all();
            return view('kamar.index', compact('kamars'));
        }
    
        public function create()
        {
            return view('kamar.create');
        }
    
        public function store(Request $request)
        {
            $request->validate(['nama' => 'required|string|max:255']);
            Kamar::create($request->only('nama'));
            return redirect()->route('kamar.index')->with('success', 'Data kamar berhasil ditambahkan.');
        }
    
        public function edit(Kamar $kamar)
        {
            return view('kamar.edit', compact('kamar'));
        }
    
        public function update(Request $request, Kamar $kamar)
        {
            $request->validate(['nama' => 'required|string|max:255']);
            $kamar->update($request->only('nama'));
            return redirect()->route('kamar.index')->with('success', 'Data kamar berhasil diupdate.');
        }
    
        public function destroy(Kamar $kamar)
        {
            $kamar->delete();
            return redirect()->route('kamar.index')->with('success', 'Data kamar berhasil dihapus.');
        }
    }

