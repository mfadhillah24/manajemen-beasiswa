<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Seleksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogHelper;

class SeleksiController extends Controller
{
    public function index()
    {
        // Tampilkan semua pendaftaran yang sudah Verified atau sudah di-seleksi
        $pendaftarans = Pendaftaran::with(['mahasiswa.user', 'beasiswa.kategoriBeasiswa', 'seleksi'])
            ->whereIn('status_pendaftaran', ['Verified', 'Approved', 'Rejected'])
            ->latest()
            ->get();

        return view('seleksi.index', [
            'title' => 'Proses Seleksi Beasiswa',
            'pendaftarans' => $pendaftarans,
        ]);
    }

    public function create(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->seleksi) {
            return to_route('seleksi.show', $pendaftaran->seleksi->id);
        }

        return view('seleksi.create', [
            'title' => 'Form Penilaian Komite',
            'pendaftaran' => $pendaftaran->load(['mahasiswa.user', 'beasiswa.kategoriBeasiswa', 'dokumens']),
        ]);
    }

    public function store(Request $request, Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->seleksi) {
            return to_route('seleksi.index')->withError('Pendaftaran ini sudah dinilai.');
        }

        $request->validate([
            'nilai_berkas' => 'required|numeric|min:0|max:100',
            'nilai_wawancara' => 'required|numeric|min:0|max:100',
            'nilai_prestasi' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
            'rekomendasi' => 'required|in:Ya,Tidak',
        ]);

        // Hitung skor akhir: (Berkas 30%) + (Wawancara 40%) + (Prestasi 30%)
        $skor_akhir = ($request->nilai_berkas * 0.30) + ($request->nilai_wawancara * 0.40) + ($request->nilai_prestasi * 0.30);

        DB::beginTransaction();

        try {
            $seleksi = Seleksi::create([
                'pendaftaran_id' => $pendaftaran->id,
                'penilai_id' => Auth::id(),
                'nilai_berkas' => $request->nilai_berkas,
                'nilai_wawancara' => $request->nilai_wawancara,
                'nilai_prestasi' => $request->nilai_prestasi,
                'skor_akhir' => $skor_akhir,
                'catatan' => $request->catatan,
                'rekomendasi' => $request->rekomendasi,
            ]);

            // Optional: update status pendaftaran jika komite yang memutuskan
            if ($request->rekomendasi === 'Ya') {
                $pendaftaran->update(['status_pendaftaran' => 'Approved']);
            } else {
                $pendaftaran->update(['status_pendaftaran' => 'Rejected']);
            }

            LogHelper::record('Penilaian Seleksi', 'Komite memberikan penilaian untuk pendaftaran ID: ' . $pendaftaran->id . ' dengan hasil: ' . $pendaftaran->status_pendaftaran);

            DB::commit();
            return to_route('seleksi.index')->withSuccess('Penilaian berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Seleksi $seleksi)
    {
        return view('seleksi.show', [
            'title' => 'Detail Penilaian',
            'seleksi' => $seleksi->load(['pendaftaran.mahasiswa.user', 'pendaftaran.beasiswa.kategoriBeasiswa', 'penilai']),
        ]);
    }
}
