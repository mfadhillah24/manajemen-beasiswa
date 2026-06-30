<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row g-4 mt-1">

        {{-- Info Pendaftaran --}}
        <div class="col-md-6">
            <div class="card shadow-lg border-0 h-100 p-4">
                <h5 class="fw-bold border-bottom pb-2 mb-3">Informasi Pendaftar</h5>
                <table class="table table-borderless">
                    <tr>
                        <td style="width:140px" class="fw-bold">Nama</td>
                        <td>: {{ $seleksi->pendaftaran->mahasiswa->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">NIM</td>
                        <td>: {{ $seleksi->pendaftaran->mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Beasiswa</td>
                        <td>: {{ $seleksi->pendaftaran->beasiswa->nama_beasiswa }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Status Akhir</td>
                        <td>:
                            @php
                                $statusColor = match($seleksi->pendaftaran->status_pendaftaran) {
                                    'Approved' => 'success',
                                    'Rejected' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusColor }} fs-6 px-3 py-2">{{ $seleksi->pendaftaran->status_pendaftaran }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Penilai</td>
                        <td>: {{ $seleksi->penilai->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Tanggal Penilaian</td>
                        <td>: {{ $seleksi->created_at->format('d F Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Hasil Penilaian --}}
        <div class="col-md-6">
            <div class="card shadow-lg border-0 h-100 p-4">
                <h5 class="fw-bold border-bottom pb-2 mb-3">Hasil Penilaian</h5>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Nilai Berkas <small class="text-muted">(Bobot 30%)</small></span>
                        <strong>{{ $seleksi->nilai_berkas }} / 100</strong>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $seleksi->nilai_berkas }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Nilai Wawancara <small class="text-muted">(Bobot 40%)</small></span>
                        <strong>{{ $seleksi->nilai_wawancara }} / 100</strong>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $seleksi->nilai_wawancara }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Nilai Prestasi <small class="text-muted">(Bobot 30%)</small></span>
                        <strong>{{ $seleksi->nilai_prestasi }} / 100</strong>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $seleksi->nilai_prestasi }}%"></div>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold m-0">Skor Akhir</h6>
                    <span class="fs-3 fw-bold text-primary">{{ number_format($seleksi->skor_akhir, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold m-0">Rekomendasi</h6>
                    @php $rekColor = $seleksi->rekomendasi === 'Ya' ? 'success' : 'danger'; @endphp
                    <span class="badge bg-{{ $rekColor }} fs-5 px-3 py-2">{{ $seleksi->rekomendasi === 'Ya' ? '✅ Layak' : '❌ Tidak Layak' }}</span>
                </div>

                @if($seleksi->catatan)
                <div class="alert alert-light border">
                    <small class="text-muted">Catatan Komite:</small>
                    <p class="m-0">{{ $seleksi->catatan }}</p>
                </div>
                @endif

            </div>
        </div>

    </div>

    <div class="text-end mt-3">
        <a href="{{ route('seleksi.index') }}" class="btn btn-primary">Kembali</a>
    </div>

</x-app>
