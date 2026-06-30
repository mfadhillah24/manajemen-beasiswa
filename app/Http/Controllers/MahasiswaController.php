<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class MahasiswaController extends Controller
{
    // ==========================================
    // BAGIAN ADMIN: MENGELOLA DATA AKADEMIK
    // ==========================================

    public function index()
    {
        $mahasiswas = Mahasiswa::with('user')->latest()->get();

        return view('mahasiswa.index', [
            'title' => 'Data Akademik Mahasiswa',
            'mahasiswas' => $mahasiswas,
        ]);
    }

    public function create()
    {
        return view('mahasiswa.create', [
            'title' => 'Tambah Mahasiswa',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nim' => 'required|string|unique:mahasiswas,nim',
            'prodi' => 'required|string',
            'fakultas' => 'required|string',
            'ipk' => 'required|numeric|min:0|max:4.00',
            'semester' => 'required|integer|min:1',
            'no_hp' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'Mahasiswa',
                'email_verified_at' => now(),
            ]);

            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'prodi' => $request->prodi,
                'fakultas' => $request->fakultas,
                'ipk' => $request->ipk,
                'semester' => $request->semester,
                'no_hp' => $request->no_hp,
            ]);

            DB::commit();

            return to_route('akademik.index')->withSuccess('Mahasiswa baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal menambahkan mahasiswa: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Mahasiswa $akademik)
    {
        return view('mahasiswa.edit', [
            'title' => 'Edit Data Akademik',
            'mahasiswa' => $akademik->load('user'),
        ]);
    }

    public function update(Request $request, Mahasiswa $akademik)
    {
        $request->validate([
            'nim' => 'required|string|unique:mahasiswas,nim,' . $akademik->id,
            'prodi' => 'required|string',
            'fakultas' => 'required|string',
            'ipk' => 'required|numeric|min:0|max:4.00',
            'semester' => 'required|integer|min:1',
            'no_hp' => 'nullable|string',
        ]);

        $akademik->update([
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'fakultas' => $request->fakultas,
            'ipk' => $request->ipk,
            'semester' => $request->semester,
            'no_hp' => $request->no_hp,
        ]);

        return to_route('akademik.index')->withSuccess('Data akademik berhasil diperbarui.');
    }

    // ==========================================
    // BAGIAN MAHASISWA: MELIHAT PROFIL SENDIRI
    // ==========================================

    public function profile()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // Jika belum ada data mahasiswa, tampilkan pesan kosong (bisa juga diarahkan untuk hubungi admin)
        return view('mahasiswa.profile', [
            'title' => 'Profil Akademik Saya',
            'mahasiswa' => $mahasiswa,
        ]);
    }
}
