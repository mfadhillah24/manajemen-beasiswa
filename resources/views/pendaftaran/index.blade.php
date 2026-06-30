<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    @if (isset($error))
        <div class="alert alert-danger shadow-sm border-0 d-flex align-items-center" role="alert">
            <i class='bx bx-error-circle fs-3 me-2'></i>
            <div>
                {{ $error }}
            </div>
        </div>
    @else
        <!-- Profil Akademik Singkat -->
        <div class="card shadow-sm border-0 mb-4 bg-primary text-white">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="fw-bold mb-1">Halo, {{ Auth::user()->name }}!</h4>
                        <p class="mb-0 opacity-75">NIM: {{ Auth::user()->mahasiswa->nim }} | Prodi: {{ Auth::user()->mahasiswa->prodi }}</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <span class="badge bg-white text-primary fs-6 py-2 px-3">
                            <i class='bx bx-book-bookmark me-1'></i> IPK Anda: {{ number_format(Auth::user()->mahasiswa->ipk, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Beasiswa yang Tersedia -->
        <h5 class="fw-bold mb-3"><i class='bx bx-award me-1 text-primary'></i> Program Beasiswa yang Dibuka</h5>
        <div class="row g-4 mb-5">
            @forelse ($beasiswas as $beasiswa)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded">
                                    {{ $beasiswa->kategoriBeasiswa->nama_kategori }}
                                </span>
                                <small class="text-danger fw-semibold">
                                    <i class='bx bx-calendar me-1'></i> Sisa {{ \Carbon\Carbon::parse($beasiswa->tanggal_tutup)->diffInDays(now()) }} Hari
                                </small>
                            </div>
                            <h5 class="fw-bold mb-2">{{ $beasiswa->nama_beasiswa }}</h5>
                            <p class="text-muted small flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $beasiswa->deskripsi }}
                            </p>
                            <div class="border-top pt-3 mt-3">
                                <div class="d-flex justify-content-between text-muted small mb-3">
                                    <span>Syarat IPK Min: <strong class="text-dark">{{ number_format($beasiswa->syarat_ipk_minimal, 2) }}</strong></span>
                                    <span>Kuota: <strong class="text-dark">{{ $beasiswa->kuota }} orang</strong></span>
                                </div>
                                @if (Auth::user()->mahasiswa->ipk >= $beasiswa->syarat_ipk_minimal)
                                    <a href="{{ route('pendaftaran.create', ['beasiswa_id' => $beasiswa->id]) }}" class="btn btn-primary w-100">
                                        Daftar Sekarang
                                    </a>
                                @else
                                    <button class="btn btn-secondary w-100" disabled>
                                        IPK Tidak Memenuhi Syarat
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm p-4 text-center">
                        <p class="text-muted mb-0">Saat ini belum ada program beasiswa aktif yang dibuka.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Riwayat Pendaftaran -->
        <h5 class="fw-bold mb-3"><i class='bx bx-history me-1 text-primary'></i> Riwayat Pendaftaran Anda</h5>
        <div class="card shadow-sm border-0 p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped w-100" id="data-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Beasiswa</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Tanggal Daftar</th>
                            <th scope="col">Status Pendaftaran</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendaftarans as $pendaftaran)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pendaftaran->beasiswa->nama_beasiswa }}</td>
                                <td>{{ $pendaftaran->beasiswa->kategoriBeasiswa->nama_kategori }}</td>
                                <td>{{ $pendaftaran->tanggal_daftar->format('d F Y') }}</td>
                                <td>
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
                                    <span class="badge bg-{{ $color }}">
                                        {{ $pendaftaran->status_pendaftaran }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('pendaftaran.show', $pendaftaran) }}" class="btn btn-info btn-sm">
                                        <i class='bx bx-show'></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</x-app>
