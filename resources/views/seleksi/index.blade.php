<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg border-0 mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold m-0">Daftar Pendaftar Siap Dinilai</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width:5%">No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Program Beasiswa</th>
                            <th>Skor Akhir</th>
                            <th>Rekomendasi</th>
                            <th>Status</th>
                            <th style="width:10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftarans as $pendaftaran)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pendaftaran->mahasiswa->user->name ?? '-' }}</td>
                            <td><code>{{ $pendaftaran->mahasiswa->nim ?? '-' }}</code></td>
                            <td>{{ $pendaftaran->beasiswa->nama_beasiswa ?? '-' }}</td>
                            <td>
                                @if($pendaftaran->seleksi)
                                    <span class="fw-bold text-primary">{{ number_format($pendaftaran->seleksi->skor_akhir, 2) }}</span>
                                @else
                                    <span class="text-muted fst-italic">Belum dinilai</span>
                                @endif
                            </td>
                            <td>
                                @if($pendaftaran->seleksi)
                                    @php $rekColor = $pendaftaran->seleksi->rekomendasi === 'Ya' ? 'success' : 'danger'; @endphp
                                    <span class="badge bg-{{ $rekColor }}">{{ $pendaftaran->seleksi->rekomendasi }}</span>
                                @else
                                    <span class="badge bg-secondary">Pending</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusColor = match($pendaftaran->status_pendaftaran) {
                                        'Verified' => 'warning',
                                        'Approved' => 'success',
                                        'Rejected' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusColor }}">{{ $pendaftaran->status_pendaftaran }}</span>
                            </td>
                            <td>
                                @if(!$pendaftaran->seleksi && Auth::user()->hasRole('Komite'))
                                    <a href="{{ route('seleksi.create', $pendaftaran->id) }}" class="btn btn-sm btn-primary">
                                        <i class='bx bx-star me-1'></i> Nilai
                                    </a>
                                @elseif($pendaftaran->seleksi)
                                    <a href="{{ route('seleksi.show', $pendaftaran->seleksi->id) }}" class="btn btn-sm btn-secondary">
                                        <i class='bx bx-show me-1'></i> Detail
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class='bx bx-inbox fs-2 d-block mb-2'></i>
                                Belum ada pendaftar yang berstatus Verified.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app>
