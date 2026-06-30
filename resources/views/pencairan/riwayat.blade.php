<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-lg border-0 mt-3">
        <div class="card-body">
            <h5 class="fw-bold mb-4">Riwayat Pencairan Dana & Unggah Laporan Pertanggungjawaban</h5>

            @if($pencairans->isEmpty())
                <div class="alert alert-info">
                    <i class='bx bx-info-circle me-1'></i>
                    Anda belum memiliki riwayat pencairan beasiswa. Laporan akan muncul di sini setelah Admin mencairkan dana.
                </div>
            @else
                @foreach($pencairans as $item)
                <div class="card border mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-0">{{ $item->pendaftaran->beasiswa->nama_beasiswa ?? '-' }}</h6>
                            <small class="text-muted">Dicairkan: {{ $item->tanggal_cair->format('d F Y') }}</small>
                        </div>
                        <span class="fs-5 fw-bold text-success">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Bukti Transfer</h6>
                                @if($item->bukti_transfer_path)
                                    <a href="{{ asset('storage/' . $item->bukti_transfer_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class='bx bx-file'></i> Lihat Bukti Transfer
                                    </a>
                                @else
                                    <span class="text-muted">Tidak tersedia</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <h6 class="fw-bold">Status Laporan Pertanggungjawaban</h6>
                                @php
                                    $badge = match($item->status_laporan) {
                                        'Belum Diunggah'       => 'secondary',
                                        'Menunggu Verifikasi'  => 'warning',
                                        'Disetujui'            => 'success',
                                        'Ditolak'              => 'danger',
                                        default                => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }} fs-6 py-2 px-3 mb-2">{{ $item->status_laporan }}</span>

                                @if($item->catatan_admin)
                                    <div class="alert alert-warning py-2 mt-2">
                                        <small><strong>Catatan Admin:</strong> {{ $item->catatan_admin }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <hr>

                        {{-- Form Upload LPJ --}}
                        @if(in_array($item->status_laporan, ['Belum Diunggah', 'Ditolak']))
                            <h6 class="fw-bold">
                                {{ $item->status_laporan == 'Ditolak' ? 'Unggah Ulang' : 'Unggah' }} Laporan Pertanggungjawaban
                            </h6>
                            <form action="{{ route('pencairan.upload_laporan', $item->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="input-group">
                                    <input type="file" class="form-control @error('file_laporan') is-invalid @enderror"
                                           name="file_laporan" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <button type="submit" class="btn btn-primary">
                                        <i class='bx bx-upload me-1'></i> Unggah LPJ
                                    </button>
                                </div>
                                <div class="form-text">Format: PDF, JPG, PNG. Maks. 5MB.</div>
                                @error('file_laporan')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </form>
                        @elseif($item->file_laporan_pertanggungjawaban)
                            <a href="{{ asset('storage/' . $item->file_laporan_pertanggungjawaban) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                <i class='bx bx-download me-1'></i> Lihat File LPJ yang Diunggah
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app>
