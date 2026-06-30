<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\KategoriBeasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('beasiswa.index', [
            'title' => 'Kelola Beasiswa',
            'beasiswas' => Beasiswa::with('kategoriBeasiswa')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('beasiswa.create', [
            'title' => 'Tambah Beasiswa',
            'kategoris' => KategoriBeasiswa::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'kategori_beasiswa_id' => 'required|exists:kategori_beasiswas,id',
            'nama_beasiswa' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'syarat_ipk_minimal' => 'required|numeric|min:0|max:4',
            'kuota' => 'required|integer|min:1',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date|after_or_equal:tanggal_buka',
            'status' => 'required|in:Aktif,Nonaktif',
        ], [
            'kategori_beasiswa_id.required' => 'Kategori beasiswa wajib dipilih',
            'kategori_beasiswa_id.exists' => 'Kategori beasiswa tidak valid',
            'nama_beasiswa.required' => 'Nama beasiswa wajib diisi',
            'syarat_ipk_minimal.required' => 'Syarat IPK minimal wajib diisi',
            'syarat_ipk_minimal.numeric' => 'Syarat IPK harus berupa angka',
            'syarat_ipk_minimal.min' => 'Syarat IPK minimal 0',
            'syarat_ipk_minimal.max' => 'Syarat IPK maksimal 4',
            'kuota.required' => 'Kuota wajib diisi',
            'kuota.integer' => 'Kuota harus berupa angka bulat',
            'kuota.min' => 'Kuota minimal 1',
            'tanggal_buka.required' => 'Tanggal buka wajib diisi',
            'tanggal_tutup.required' => 'Tanggal tutup wajib diisi',
            'tanggal_tutup.after_or_equal' => 'Tanggal tutup harus setelah atau sama dengan tanggal buka',
            'status.required' => 'Status wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            Beasiswa::create($validate);
            DB::commit();
            return to_route('beasiswa.index')->withSuccess('Beasiswa berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('beasiswa.create')->withError('Gagal menambahkan beasiswa: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Beasiswa $beasiswa)
    {
        return view('beasiswa.show', [
            'title' => 'Detail Beasiswa',
            'beasiswa' => $beasiswa->load('kategoriBeasiswa'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beasiswa $beasiswa)
    {
        return view('beasiswa.edit', [
            'title' => 'Edit Beasiswa',
            'beasiswa' => $beasiswa,
            'kategoris' => KategoriBeasiswa::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beasiswa $beasiswa)
    {
        $validate = $request->validate([
            'kategori_beasiswa_id' => 'required|exists:kategori_beasiswas,id',
            'nama_beasiswa' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'syarat_ipk_minimal' => 'required|numeric|min:0|max:4',
            'kuota' => 'required|integer|min:1',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date|after_or_equal:tanggal_buka',
            'status' => 'required|in:Aktif,Nonaktif',
        ], [
            'kategori_beasiswa_id.required' => 'Kategori beasiswa wajib dipilih',
            'kategori_beasiswa_id.exists' => 'Kategori beasiswa tidak valid',
            'nama_beasiswa.required' => 'Nama beasiswa wajib diisi',
            'syarat_ipk_minimal.required' => 'Syarat IPK minimal wajib diisi',
            'syarat_ipk_minimal.numeric' => 'Syarat IPK harus berupa angka',
            'syarat_ipk_minimal.min' => 'Syarat IPK minimal 0',
            'syarat_ipk_minimal.max' => 'Syarat IPK maksimal 4',
            'kuota.required' => 'Kuota wajib diisi',
            'kuota.integer' => 'Kuota harus berupa angka bulat',
            'kuota.min' => 'Kuota minimal 1',
            'tanggal_buka.required' => 'Tanggal buka wajib diisi',
            'tanggal_tutup.required' => 'Tanggal tutup wajib diisi',
            'tanggal_tutup.after_or_equal' => 'Tanggal tutup harus setelah atau sama dengan tanggal buka',
            'status.required' => 'Status wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            $beasiswa->update($validate);
            DB::commit();
            return to_route('beasiswa.index')->withSuccess('Beasiswa berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('beasiswa.edit', $beasiswa)->withError('Gagal memperbarui beasiswa: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beasiswa $beasiswa)
    {
        DB::beginTransaction();

        try {
            $beasiswa->delete();
            DB::commit();
            return to_route('beasiswa.index')->withSuccess('Beasiswa berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('beasiswa.index')->withError('Gagal menghapus beasiswa: ' . $e->getMessage());
        }
    }
}
