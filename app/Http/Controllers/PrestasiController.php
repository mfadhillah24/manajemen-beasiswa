<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('dashboard.index')->withError('Profil akademik belum lengkap.');
        }

        $prestasis = Prestasi::where('mahasiswa_id', $mahasiswa->id)->latest()->get();

        return view('prestasi.index', [
            'title' => 'Prestasi Saya',
            'prestasis' => $prestasis
        ]);
    }

    public function create()
    {
        return view('prestasi.create', [
            'title' => 'Tambah Prestasi'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tingkat' => 'required|in:Lokal,Nasional,Internasional',
            'jenis' => 'required|in:Akademik,Non-Akademik',
            'file_sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $mahasiswa = Auth::user()->mahasiswa;

        if ($request->hasFile('file_sertifikat')) {
            $path = $request->file('file_sertifikat')->store('sertifikats', 'public');
        }

        Prestasi::create([
            'mahasiswa_id' => $mahasiswa->id,
            'nama_prestasi' => $request->nama_prestasi,
            'tingkat' => $request->tingkat,
            'jenis' => $request->jenis,
            'file_sertifikat' => $path ?? null,
            'tahun' => $request->tahun,
        ]);

        return redirect()->route('prestasi.index')->withSuccess('Prestasi berhasil ditambahkan.');
    }

    public function edit(Prestasi $prestasi)
    {
        $mahasiswa = Auth::user()->mahasiswa;
        if ($prestasi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        return view('prestasi.edit', [
            'title' => 'Edit Prestasi',
            'prestasi' => $prestasi
        ]);
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $mahasiswa = Auth::user()->mahasiswa;
        if ($prestasi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tingkat' => 'required|in:Lokal,Nasional,Internasional',
            'jenis' => 'required|in:Akademik,Non-Akademik',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $data = [
            'nama_prestasi' => $request->nama_prestasi,
            'tingkat' => $request->tingkat,
            'jenis' => $request->jenis,
            'tahun' => $request->tahun,
        ];

        if ($request->hasFile('file_sertifikat')) {
            if ($prestasi->file_sertifikat) {
                Storage::disk('public')->delete($prestasi->file_sertifikat);
            }
            $data['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikats', 'public');
        }

        $prestasi->update($data);

        return redirect()->route('prestasi.index')->withSuccess('Prestasi berhasil diperbarui.');
    }

    public function destroy(Prestasi $prestasi)
    {
        $mahasiswa = Auth::user()->mahasiswa;
        if ($prestasi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($prestasi->file_sertifikat) {
            Storage::disk('public')->delete($prestasi->file_sertifikat);
        }

        $prestasi->delete();

        return redirect()->route('prestasi.index')->withSuccess('Prestasi berhasil dihapus.');
    }
}
