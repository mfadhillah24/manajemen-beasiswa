<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogHelper;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Admin dan Komite: tampilkan semua pendaftaran untuk diverifikasi
        if ($user->hasRole(['Admin', 'Komite'])) {
            $pendaftarans = Pendaftaran::with(['beasiswa', 'mahasiswa.user'])
                ->latest()
                ->get();

            return view('pendaftaran.admin_index', [
                'title'        => 'Daftar Semua Pendaftaran',
                'pendaftarans' => $pendaftarans,
            ]);
        }

        // Mahasiswa: hanya tampilkan miliknya sendiri
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return view('pendaftaran.index', [
                'title'        => 'Pendaftaran Beasiswa',
                'error'        => 'Profil akademik Anda belum terdaftar. Silakan hubungi Administrator untuk melengkapi data NIM & IPK Anda.',
                'beasiswas'    => [],
                'pendaftarans' => [],
            ]);
        }

        // Ambil beasiswa yang aktif dan bisa didaftar
        $beasiswas = Beasiswa::with('kategoriBeasiswa')
            ->where('status', 'Aktif')
            ->where('tanggal_buka', '<=', now())
            ->where('tanggal_tutup', '>=', now())
            ->get();

        // Ambil riwayat pendaftaran mahasiswa ini
        $pendaftarans = Pendaftaran::with('beasiswa.kategoriBeasiswa')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->get();

        return view('pendaftaran.index', [
            'title'        => 'Pendaftaran Beasiswa',
            'beasiswas'    => $beasiswas,
            'pendaftarans' => $pendaftarans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $beasiswaId = $request->query('beasiswa_id');
        $beasiswa = Beasiswa::with('kategoriBeasiswa')->findOrFail($beasiswaId);
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa) {
            return to_route('pendaftaran.index')->withError('Profil akademik tidak ditemukan.');
        }

        // Validasi double apply
        $exists = Pendaftaran::where('mahasiswa_id', $mahasiswa->id)
            ->where('beasiswa_id', $beasiswa->id)
            ->exists();

        if ($exists) {
            return to_route('pendaftaran.index')->withError('Anda sudah mendaftar pada beasiswa ini.');
        }

        // Validasi IPK
        if ($mahasiswa->ipk < $beasiswa->syarat_ipk_minimal) {
            return to_route('pendaftaran.index')->withError('IPK Anda (' . $mahasiswa->ipk . ') tidak memenuhi syarat minimal (' . $beasiswa->syarat_ipk_minimal . ') untuk beasiswa ini.');
        }

        return view('pendaftaran.create', [
            'title' => 'Formulir Pendaftaran Beasiswa',
            'beasiswa' => $beasiswa,
            'mahasiswa' => $mahasiswa,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'beasiswa_id' => 'required|exists:beasiswas,id',
        ]);

        $mahasiswa = Auth::user()->mahasiswa;
        if (!$mahasiswa) {
            return to_route('pendaftaran.index')->withError('Profil akademik tidak ditemukan.');
        }

        $beasiswa = Beasiswa::findOrFail($request->beasiswa_id);

        // Double apply check
        $exists = Pendaftaran::where('mahasiswa_id', $mahasiswa->id)
            ->where('beasiswa_id', $beasiswa->id)
            ->exists();

        if ($exists) {
            return to_route('pendaftaran.index')->withError('Anda sudah mendaftar pada beasiswa ini.');
        }

        // IPK check
        if ($mahasiswa->ipk < $beasiswa->syarat_ipk_minimal) {
            return to_route('pendaftaran.index')->withError('IPK Anda tidak memenuhi syarat minimal.');
        }

        DB::beginTransaction();

        try {
            Pendaftaran::create([
                'mahasiswa_id' => $mahasiswa->id,
                'beasiswa_id' => $beasiswa->id,
                'tanggal_daftar' => now(),
                'status_pendaftaran' => 'Submitted',
            ]);

            LogHelper::record('Mendaftar Beasiswa', 'Mahasiswa mendaftar beasiswa: ' . $beasiswa->nama_beasiswa);

            DB::commit();
            return to_route('pendaftaran.index')->withSuccess('Pendaftaran beasiswa berhasil dikirim.');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('pendaftaran.index')->withError('Gagal mengirim pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendaftaran $pendaftaran)
    {
        $user = Auth::user();
        $isOwner = $user->mahasiswa && $pendaftaran->mahasiswa_id === $user->mahasiswa->id;
        $canVerify = $user->hasRole('Admin') || $user->hasRole('Komite');

        if (!$isOwner && !$canVerify) {
            abort(403, 'Unauthorized action.');
        }

        return view('pendaftaran.show', [
            'title' => 'Detail Pendaftaran',
            'pendaftaran' => $pendaftaran->load(['beasiswa.kategoriBeasiswa', 'mahasiswa.user', 'dokumens']),
        ]);
    }

    /**
     * Update the status of pendaftaran to Verified by Admin
     */
    public function verify(Request $request, Pendaftaran $pendaftaran)
    {
        $user = Auth::user();
        if (!$user->hasRole('Admin') && !$user->hasRole('Komite')) {
            abort(403, 'Unauthorized action.');
        }

        $pendaftaran->update([
            'status_pendaftaran' => 'Verified'
        ]);

        LogHelper::record('Verifikasi Pendaftaran', 'Admin/Komite memverifikasi pendaftaran ID: ' . $pendaftaran->id);

        return back()->withSuccess('Pendaftaran berhasil diverifikasi. Peserta sekarang masuk ke tahap seleksi Komite.');
    }
}
