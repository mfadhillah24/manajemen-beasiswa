<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-lg border-0 mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold m-0">Daftar Pencairan Dana Beasiswa</h5>
                @if(in_array(Auth::user()->role, ['Admin', 'Superadmin']))
                    <a href="{{ route('pencairan.create') }}" class="btn btn-primary">
                        <i class='bx bx-plus me-1'></i> Input Pencairan Baru
                    </a>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="data-table">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Program Beasiswa</th>
                            <th>Nominal</th>
                            <th>Tanggal Cair</th>
                            <th>Status Laporan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pencairans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $item->pendaftaran->mahasiswa->user->name ?? '-' }}</td>
                            <td>{{ $item->pendaftaran->beasiswa->nama_beasiswa ?? '-' }}</td>
                            <td>
                                <span class="fw-bold text-success">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                            </td>
                            <td>{{ $item->tanggal_cair->format('d M Y') }}</td>
                            <td>
                                @php
                                    $badge = match($item->status_laporan) {
                                        'Belum Diunggah'       => 'secondary',
                                        'Menunggu Verifikasi'  => 'warning',
                                        'Disetujui'            => 'success',
                                        'Ditolak'              => 'danger',
                                        default                => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $item->status_laporan }}</span>
                            </td>
                            <td>
                                <a href="{{ route('pencairan.show', $item->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class='bx bx-show'></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data pencairan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app>
