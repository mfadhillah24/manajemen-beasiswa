<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Beasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('Mahasiswa')) {
            $pengumumans = Pengumuman::with('beasiswa')->where('tanggal_tampil', '<=', now())->latest()->get();
            return view('pengumuman.index', compact('pengumumans'));
        }

        $pengumumans = Pengumuman::with('beasiswa')->latest()->get();
        return view('pengumuman.index', compact('pengumumans'));
    }

    public function create()
    {
        $beasiswas = Beasiswa::all();
        return view('pengumuman.create', compact('beasiswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'beasiswa_id' => 'required|exists:beasiswas,id',
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'tanggal_tampil' => 'required|date',
        ]);

        Pengumuman::create($request->all());

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function edit(Pengumuman $pengumuman)
    {
        $beasiswas = Beasiswa::all();
        return view('pengumuman.edit', compact('pengumuman', 'beasiswas'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'beasiswa_id' => 'required|exists:beasiswas,id',
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'tanggal_tampil' => 'required|date',
        ]);

        $pengumuman->update($request->all());

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diupdate');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus');
    }
}
