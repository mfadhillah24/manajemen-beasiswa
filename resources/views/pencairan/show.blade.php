<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row g-4 mt-1">

        {{-- Informasi Pencairan --}}
        <div class="col-md-6">
            <div class="card shadow-lg border-0 h-100 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class='bx bx-money me-1 text-success'></i> Info Pencairan Dana</h5>
                <table class="table table-borderless">
                    <tr>
                        <td class="fw-bold" style="width:180px">Mahasiswa</td>
                        <td>: {{ $pencairan->pendaftaran->mahasiswa->user->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Program Beasiswa</td>
                        <td>: {{ $pencairan->pendaftaran->beasiswa->nama_beasiswa ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Nominal Cair</td>
                        <td>: <span class="fw-bold text-success fs-5">Rp {{ number_format($pencairan->nominal, 0, ',', '.') }}</span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Tanggal Cair</td>
                        <td>: {{ $pencairan->tanggal_cair->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Bukti Transfer</td>
                        <td>:
                            @if($pencairan->bukti_transfer_path)
                                <a href="{{ asset('storage/' . $pencairan->bukti_transfer_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class='bx bx-file'></i> Lihat Bukti
                                </a>
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Status Laporan Pertanggungjawaban --}}
        <div class="col-md-6">
            <div class="card shadow-lg border-0 h-100 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class='bx bx-file-blank me-1 text-warning'></i> Laporan Pertanggungjawaban (LPJ)</h5>

                @php
                    $badge = match($pencairan->status_laporan) {
                        'Belum Diunggah'       => 'secondary',
                        'Menunggu Verifikasi'  => 'warning',
                        'Disetujui'            => 'success',
                        'Ditolak'              => 'danger',
                        default                => 'secondary',
                    };
                @endphp

                <div class="mb-3">
                    <span class="badge bg-{{ $badge }} fs-6 py-2 px-3">{{ $pencairan->status_laporan }}</span>
                </div>

                @if($pencairan->file_laporan_pertanggungjawaban)
                    <div class="mb-3">
                        <a href="{{ asset('storage/' . $pencairan->file_laporan_pertanggungjawaban) }}" target="_blank" class="btn btn-outline-info">
                            <i class='bx bx-download me-1'></i> Download File LPJ
                        </a>
                    </div>
                @else
                    <p class="text-muted fst-italic">Mahasiswa belum mengunggah laporan.</p>
                @endif

                @if($pencairan->catatan_admin)
                    <div class="alert alert-light border mt-2">
                        <strong>Catatan Admin:</strong><br>{{ $pencairan->catatan_admin }}
                    </div>
                @endif

                {{-- Form Verifikasi Admin --}}
                @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Superadmin'))
                    @if(in_array($pencairan->status_laporan, ['Menunggu Verifikasi', 'Ditolak']))
                        <hr>
                        <h6 class="fw-bold">Verifikasi Laporan</h6>
                        <form action="{{ route('pencairan.verifikasi_laporan', $pencairan->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label class="form-label">Keputusan</label>
                                <select name="status_laporan" class="form-select" required>
                                    <option value="Disetujui">✅ Disetujui</option>
                                    <option value="Ditolak">❌ Ditolak</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan (Opsional)</label>
                                <textarea name="catatan_admin" class="form-control" rows="2"
                                    placeholder="Tulis catatan jika laporan ditolak...">{{ old('catatan_admin', $pencairan->catatan_admin) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class='bx bx-check-shield me-1'></i> Simpan Verifikasi
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('pencairan.index') }}" class="btn btn-secondary">
            <i class='bx bx-arrow-back me-1'></i> Kembali
        </a>
    </div>
</x-app>
