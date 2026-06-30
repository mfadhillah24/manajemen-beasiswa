<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class='bx bx-check-circle me-1'></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class='bx bx-error-circle me-1'></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-lg border-0 mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold m-0">
                    <i class='bx bx-list-check me-2 text-primary'></i>
                    Daftar Semua Pendaftaran Beasiswa
                </h5>
                {{-- Filter Status --}}
                <div class="d-flex gap-2 align-items-center">
                    <span class="text-muted small">Filter:</span>
                    <a href="{{ request()->url() }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-secondary' }}">Semua</a>
                    <a href="?status=Submitted" class="btn btn-sm {{ request('status') == 'Submitted' ? 'btn-info text-white' : 'btn-outline-info' }}">Submitted</a>
                    <a href="?status=Verified" class="btn btn-sm {{ request('status') == 'Verified' ? 'btn-warning' : 'btn-outline-warning' }}">Verified</a>
                    <a href="?status=Approved" class="btn btn-sm {{ request('status') == 'Approved' ? 'btn-success' : 'btn-outline-success' }}">Approved</a>
                    <a href="?status=Rejected" class="btn btn-sm {{ request('status') == 'Rejected' ? 'btn-danger' : 'btn-outline-danger' }}">Rejected</a>
                </div>
            </div>

            {{-- Stats Row --}}
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card bg-info bg-opacity-10 border-0 p-3 text-center">
                        <div class="fw-bold fs-4 text-info">{{ $pendaftarans->where('status_pendaftaran', 'Submitted')->count() }}</div>
                        <small class="text-muted">Submitted (Belum Diverifikasi)</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning bg-opacity-10 border-0 p-3 text-center">
                        <div class="fw-bold fs-4 text-warning">{{ $pendaftarans->where('status_pendaftaran', 'Verified')->count() }}</div>
                        <small class="text-muted">Verified (Menunggu Seleksi)</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success bg-opacity-10 border-0 p-3 text-center">
                        <div class="fw-bold fs-4 text-success">{{ $pendaftarans->where('status_pendaftaran', 'Approved')->count() }}</div>
                        <small class="text-muted">Approved (Diterima)</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger bg-opacity-10 border-0 p-3 text-center">
                        <div class="fw-bold fs-4 text-danger">{{ $pendaftarans->where('status_pendaftaran', 'Rejected')->count() }}</div>
                        <small class="text-muted">Rejected (Ditolak)</small>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="data-table">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Program Beasiswa</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftarans as $p)
                            @if(!request('status') || $p->status_pendaftaran == request('status'))
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $p->mahasiswa->user->name ?? '-' }}</td>
                                <td><code>{{ $p->mahasiswa->nim ?? '-' }}</code></td>
                                <td>{{ $p->beasiswa->nama_beasiswa ?? '-' }}</td>
                                <td>{{ $p->tanggal_daftar ? $p->tanggal_daftar->format('d M Y') : '-' }}</td>
                                <td>
                                    @php
                                        $badgeColor = match($p->status_pendaftaran) {
                                            'Submitted' => 'info',
                                            'Verified'  => 'warning',
                                            'Approved'  => 'success',
                                            'Rejected'  => 'danger',
                                            default     => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeColor }}">{{ $p->status_pendaftaran }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('pendaftaran.show', $p->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class='bx bx-show me-1'></i> Detail / Verifikasi
                                    </a>
                                </td>
                            </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class='bx bx-inbox fs-2 d-block mb-2'></i>
                                    Belum ada pendaftaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</x-app>
