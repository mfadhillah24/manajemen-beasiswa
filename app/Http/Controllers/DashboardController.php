<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        $data = [
            'title' => 'Dashboard',
            'role' => $role,
        ];

        if ($role === 'Mahasiswa') {
            $mahasiswa = $user->mahasiswa;
            $data['total_pendaftaran'] = $mahasiswa ? \App\Models\Pendaftaran::where('mahasiswa_id', $mahasiswa->id)->count() : 0;
            $data['beasiswa_aktif'] = \App\Models\Beasiswa::where('status', 'Aktif')->where('tanggal_buka', '<=', now())->where('tanggal_tutup', '>=', now())->count();
        } elseif ($role === 'Komite') {
            $data['menunggu_seleksi'] = \App\Models\Pendaftaran::where('status_pendaftaran', 'Verified')->count();
            $data['telah_dinilai'] = \App\Models\Seleksi::where('penilai_id', $user->id)->count();
        } else {
            // Admin, Superadmin, Pimpinan
            $data['total_beasiswa'] = \App\Models\Beasiswa::count();
            $data['total_pendaftar'] = \App\Models\Pendaftaran::count();
            $data['diterima'] = \App\Models\Pendaftaran::where('status_pendaftaran', 'Approved')->count();
            $data['dana_dicairkan'] = \App\Models\Pencairan::sum('nominal');
            $data['totalUsers'] = \App\Models\User::count();
            $data['superadminCount'] = \App\Models\User::where('role', 'Superadmin')->count();
            $data['adminCount'] = \App\Models\User::where('role', 'Admin')->count();
        }

        return view('dashboard.index', $data);
    }

    public function show()
    {
        return view('dashboard.show', [
            'title' => 'My Profile',
            'user' => Auth::user()
        ]);
    }

    public function edit()
    {
        return view('dashboard.edit', [
            'title' => 'Edit Profile',
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $validate = $request->validate([
                'name' => 'required',
                'password' => 'nullable|min:8',
                'passwordconfirm' => 'nullable|same:password',
                'email' => 'required|email|lowercase|unique:users,email,' . $user->id,
                'avatar' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:512'
            ], [
                'name.required' => 'Nama wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'passwordconfirm.same' => 'Konfirmasi password tidak cocok',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'avatar.image' => 'File avatar harus berupa gambar',
                'avatar.mimes' => 'Format avatar harus png, jpg, jpeg, atau svg',
                'avatar.max' => 'Ukuran avatar tidak boleh lebih dari 512 KB',
            ]);

            if ($request->file('avatar')) {
                $validate['avatar'] = $request->file('avatar')->store('img', 'public');
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }

            if ($request->password) {
                $validate['password'] = bcrypt($request->password);
            } else {
                unset($validate['password']);
            }
            $user->update($validate);

            DB::commit();
            return to_route('dashboard.show')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('dashboard.edit')->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }
}
