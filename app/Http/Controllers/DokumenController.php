<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function store(Request $request, Pendaftaran $pendaftaran)
    {
        // Pastikan hanya mahasiswa bersangkutan yang bisa upload
        if ($pendaftaran->mahasiswa_id !== Auth::user()->mahasiswa->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'jenis_dokumen' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'file.required' => 'Pilih file terlebih dahulu.',
            'file.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG.',
            'file.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $path = $request->file('file')->store('documents', 'public');

        Dokumen::create([
            'pendaftaran_id' => $pendaftaran->id,
            'jenis_dokumen' => $request->jenis_dokumen,
            'file_path' => $path,
            'status_verifikasi' => 'Pending',
        ]);

        return back()->withSuccess('Dokumen berhasil diunggah.');
    }

    public function destroy(Dokumen $dokumen)
    {
        // Pastikan hanya mahasiswa bersangkutan yang bisa hapus
        if ($dokumen->pendaftaran->mahasiswa_id !== Auth::user()->mahasiswa->id) {
            abort(403, 'Unauthorized action.');
        }

        if (Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        return back()->withSuccess('Dokumen berhasil dihapus.');
    }

    public function verifyDocument(Request $request, Dokumen $dokumen)
    {
        // Hanya Admin / Komite yang bisa memverifikasi
        if (!Auth::user()->hasRole('Admin') && !Auth::user()->hasRole('Komite')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status_verifikasi' => 'required|in:Pending,Valid,Invalid',
        ]);

        $dokumen->update([
            'status_verifikasi' => $request->status_verifikasi,
        ]);

        return back()->withSuccess('Status dokumen berhasil diperbarui.');
    }
}
