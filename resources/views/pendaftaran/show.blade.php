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
                    @if(Auth::user()->hasRole('Admin') && $pendaftaran->status_pendaftaran == 'Submitted')
                    <form action="{{ route('pendaftaran.verify', $pendaftaran->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah semua dokumen sudah divalidasi dan Anda yakin ingin memverifikasi pendaftaran ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning me-2"><i class='bx bx-check-shield'></i> Verifikasi Pendaftaran</button>
                    </form>
                    @endif
                    <a href="{{ route('pendaftaran.index') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card shadow-lg p-4 border-0">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <h5 class="fw-bold m-0">Dokumen Persyaratan</h5>
                    @if(Auth::user()->hasRole('Mahasiswa'))
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <i class='bx bx-upload me-1'></i> Upload Dokumen
                        </button>
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Jenis Dokumen</th>
                                <th>File</th>
                                <th>Status Verifikasi</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaftaran->dokumens as $dokumen)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dokumen->jenis_dokumen }}</td>
                                <td>
                                    <a href="{{ Storage::url($dokumen->file_path) }}" target="_blank" class="text-decoration-none">
                                        <i class='bx bx-file text-primary me-1'></i> Lihat File
                                    </a>
                                </td>
                                <td>
                                    @php
                                        $badgeColor = match($dokumen->status_verifikasi) {
                                            'Pending' => 'secondary',
                                            'Valid' => 'success',
                                            'Invalid' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeColor }}">{{ $dokumen->status_verifikasi }}</span>
                                </td>
                                <td>
                                    @if(Auth::user()->hasRole('Mahasiswa'))
                                        <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class='bx bx-trash'></i></button>
                                        </form>
                                    @endif

                                    @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Komite'))
                                        <form action="{{ route('dokumen.verify', $dokumen->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_verifikasi" value="Valid">
                                            <button type="submit" class="btn btn-sm btn-success" title="Set Valid"><i class='bx bx-check'></i></button>
                                        </form>
                                        <form action="{{ route('dokumen.verify', $dokumen->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_verifikasi" value="Invalid">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Set Invalid"><i class='bx bx-x'></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">Belum ada dokumen yang diunggah.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->hasRole('Mahasiswa'))
    <!-- Modal Upload -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="{{ route('dokumen.store', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
            <h5 class="modal-title" id="uploadModalLabel">Upload Dokumen</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="jenis_dokumen" class="form-label">Jenis Dokumen <span class="text-danger">*</span></label>
                    <select name="jenis_dokumen" id="jenis_dokumen" class="form-select" required>
                        <option value="">-- Pilih Jenis Dokumen --</option>
                        <option value="KTP">KTP</option>
                        <option value="Kartu Keluarga">Kartu Keluarga</option>
                        <option value="Transkrip Nilai">Transkrip Nilai</option>
                        <option value="Sertifikat Prestasi">Sertifikat Prestasi</option>
                        <option value="Surat Rekomendasi">Surat Rekomendasi</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">File Dokumen <span class="text-danger">*</span></label>
                    <input type="file" name="file" id="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                    <small class="text-muted">Format: PDF, JPG, PNG. Maksimal: 2MB.</small>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
        </div>
    </div>
    </div>
    @endif

</x-app>
