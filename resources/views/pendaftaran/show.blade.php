<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-lg p-4 border-0 h-100">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Detail Program Beasiswa</h5>
                <table class="table table-borderless">
                    <tr>
                        <td style="width: 150px;" class="fw-bold">Nama Beasiswa</td>
                        <td>: {{ $pendaftaran->beasiswa->nama_beasiswa }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Kategori</td>
                        <td>: {{ $pendaftaran->beasiswa->kategoriBeasiswa->nama_kategori }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Syarat IPK Min.</td>
                        <td>: <span class="badge bg-primary">{{ number_format($pendaftaran->beasiswa->syarat_ipk_minimal, 2) }}</span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Batas Pendaftaran</td>
                        <td>: {{ $pendaftaran->beasiswa->tanggal_tutup->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-lg p-4 border-0 h-100 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Status Pendaftaran Anda</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td style="width: 170px;" class="fw-bold">Nomor Pendaftaran</td>
                            <td>: #REG-{{ str_pad($pendaftaran->id, 5, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal Mendaftar</td>
                            <td>: {{ $pendaftaran->tanggal_daftar->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status Saat Ini</td>
                            <td>: 
                                @php
                                    $color = match($pendaftaran->status_pendaftaran) {
                                        'Draft' => 'secondary',
                                        'Submitted' => 'info',
                                        'Verified' => 'warning',
                                        'Approved' => 'success',
                                        'Rejected' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $color }} fs-6 py-2 px-3">
                                    {{ $pendaftaran->status_pendaftaran }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    <div class="alert alert-light border shadow-sm mt-3">
                        @if ($pendaftaran->status_pendaftaran == 'Submitted')
                            <i class='bx bx-time-five text-info me-1'></i> Pendaftaran Anda telah dikirim dan sedang menunggu verifikasi berkas administrasi oleh pihak Akademik.
                        @elseif ($pendaftaran->status_pendaftaran == 'Verified')
                            <i class='bx bx-check-shield text-warning me-1'></i> Berkas Anda telah diverifikasi. Anda masuk ke tahap penilaian oleh Komite Seleksi.
                        @elseif ($pendaftaran->status_pendaftaran == 'Approved')
                            <i class='bx bx-party text-success me-2 fs-5'></i> <strong class="text-success">Selamat!</strong> Anda dinyatakan lulus seleksi penerima beasiswa ini.
                        @elseif ($pendaftaran->status_pendaftaran == 'Rejected')
                            <i class='bx bx-x-circle text-danger me-1'></i> Mohon maaf, pendaftaran Anda belum memenuhi kriteria kelayakan seleksi tahun ini. Jangan berkecil hati!
                        @endif
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('pendaftaran.index') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>

</x-app>
