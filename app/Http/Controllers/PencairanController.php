<?php

namespace App\Http\Controllers;

use App\Models\Pencairan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PencairanController extends Controller
{
    /**
     * Daftar pencairan (Admin).
     */
    public function index()
    {
        $pencairans = Pencairan::with(['pendaftaran.mahasiswa.user', 'pendaftaran.beasiswa'])
            ->latest()
            ->get();

        return view('pencairan.index', [
            'title'      => 'Manajemen Pencairan Beasiswa',
            'pencairans' => $pencairans,
        ]);
    }

    /**
     * Daftar pendaftaran Approved yang belum dicairkan — pilih untuk mencairkan (Admin).
     */
    public function create()
    {
        // Ambil pendaftaran yang sudah disetujui dan belum punya pencairan
        $pendaftarans = Pendaftaran::with(['mahasiswa.user', 'beasiswa'])
            ->where('status_pendaftaran', 'Approved')
            ->whereDoesntHave('pencairan')
            ->get();

        return view('pencairan.create', [
            'title'        => 'Tambah Data Pencairan',
            'pendaftarans' => $pendaftarans,
        ]);
    }

    /**
     * Simpan pencairan baru (Admin).
     */
    public function store(Request $request)
    {
        $request->validate([
            'pendaftaran_id'   => 'required|exists:pendaftarans,id',
            'nominal'          => 'required|numeric|min:1',
            'tanggal_cair'     => 'required|date',
            'bukti_transfer'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'pendaftaran_id.required' => 'Pilih pendaftar terlebih dahulu.',
            'nominal.required'        => 'Nominal pencairan wajib diisi.',
            'nominal.numeric'         => 'Nominal harus berupa angka.',
            'tanggal_cair.required'   => 'Tanggal cair wajib diisi.',
        ]);

        DB::beginTransaction();
        try {
            $path = null;
            if ($request->hasFile('bukti_transfer')) {
                $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            }

            Pencairan::create([
                'pendaftaran_id'  => $request->pendaftaran_id,
                'nominal'         => $request->nominal,
                'tanggal_cair'    => $request->tanggal_cair,
                'bukti_transfer_path' => $path,
                'status_laporan'  => 'Belum Diunggah',
            ]);

            DB::commit();
            return redirect()->route('pencairan.index')->withSuccess('Data pencairan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal menyimpan pencairan: ' . $e->getMessage());
        }
    }

    /**
     * Detail pencairan (Admin dapat melihat dan memverifikasi laporan).
     */
    public function show(Pencairan $pencairan)
    {
        return view('pencairan.show', [
            'title'     => 'Detail Pencairan Beasiswa',
            'pencairan' => $pencairan->load('pendaftaran.mahasiswa.user', 'pendaftaran.beasiswa'),
        ]);
    }

    /**
     * Admin memverifikasi laporan pertanggungjawaban.
     */
    public function verifikasiLaporan(Request $request, Pencairan $pencairan)
    {
        $request->validate([
            'status_laporan'  => 'required|in:Disetujui,Ditolak',
            'catatan_admin'   => 'nullable|string|max:1000',
        ]);

        $pencairan->update([
            'status_laporan' => $request->status_laporan,
            'catatan_admin'  => $request->catatan_admin,
        ]);

        return back()->withSuccess('Status laporan berhasil diperbarui menjadi ' . $request->status_laporan . '.');
    }

    /**
     * Mahasiswa mengupload laporan pertanggungjawaban.
     */
    public function uploadLaporan(Request $request, Pencairan $pencairan)
    {
        // Validasi: hanya pemilik pendaftaran yang bisa upload
        $mahasiswa = Auth::user()->mahasiswa;
        if (!$mahasiswa || $pencairan->pendaftaran->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        $request->validate([
            'file_laporan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'file_laporan.required' => 'File laporan wajib diunggah.',
            'file_laporan.mimes'    => 'Format file harus PDF, JPG, atau PNG.',
            'file_laporan.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        DB::beginTransaction();
        try {
            // Hapus file lama jika ada
            if ($pencairan->file_laporan_pertanggungjawaban) {
                Storage::disk('public')->delete($pencairan->file_laporan_pertanggungjawaban);
            }

            $path = $request->file('file_laporan')->store('laporan_lpj', 'public');

            $pencairan->update([
                'file_laporan_pertanggungjawaban' => $path,
                'status_laporan'                  => 'Menunggu Verifikasi',
            ]);

            DB::commit();
            return back()->withSuccess('Laporan pertanggungjawaban berhasil diunggah dan sedang menunggu verifikasi Admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal mengunggah laporan: ' . $e->getMessage());
        }
    }

    /**
     * Daftar pencairan milik mahasiswa yang sedang login.
     */
    public function riwayatMahasiswa()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        if (!$mahasiswa) {
            return redirect()->route('dashboard.index')->withError('Profil akademik belum lengkap.');
        }

        $pencairans = Pencairan::with(['pendaftaran.beasiswa'])
            ->whereHas('pendaftaran', fn($q) => $q->where('mahasiswa_id', $mahasiswa->id))
            ->latest()
            ->get();

        return view('pencairan.riwayat', [
            'title'      => 'Riwayat Pencairan & Laporan',
            'pencairans' => $pencairans,
        ]);
    }
}
