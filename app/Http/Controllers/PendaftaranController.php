<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Pastikan user memiliki data mahasiswa
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return view('pendaftaran.index', [
                'title' => 'Pendaftaran Beasiswa',
                'error' => 'Profil akademik Anda belum terdaftar. Silakan hubungi Administrator untuk melengkapi data NIM & IPK Anda.',
                'beasiswas' => [],
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
            'title' => 'Pendaftaran Beasiswa',
            'beasiswas' => $beasiswas,
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
        // Pastikan hanya mahasiswa bersangkutan yang bisa melihat detailnya
        if ($pendaftaran->mahasiswa_id !== Auth::user()->mahasiswa->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('pendaftaran.show', [
            'title' => 'Detail Pendaftaran',
            'pendaftaran' => $pendaftaran->load(['beasiswa.kategoriBeasiswa', 'mahasiswa.user']),
        ]);
    }
}
