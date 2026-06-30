<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Welcome Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="fw-bold mb-3">
                        <i class='bx bx-smile text-primary me-2'></i>
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-muted mb-0">
                        Anda login sebagai <span class="badge bg-primary">{{ Auth::user()->role }}</span>
                    </p>
                    <p class="text-muted mt-2">
                        <i class='bx bx-time-five me-1'></i>
                        {{ now()->isoFormat('dddd, D MMMM YYYY - HH:mm') }}
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('niceadmin/img/noprofil.png') }}"
                        alt="Avatar" class="img-fluid rounded-circle border border-3 border-primary"
                        style="max-width: 150px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        @if ($role === 'Mahasiswa')
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Total Pendaftaran Anda</p>
                                <h2 class="fw-bold mb-0">{{ $total_pendaftaran }}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-edit text-primary fs-2'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Beasiswa Aktif</p>
                                <h2 class="fw-bold mb-0">{{ $beasiswa_aktif }}</h2>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-award text-success fs-2'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($role === 'Komite')
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Menunggu Seleksi</p>
                                <h2 class="fw-bold mb-0">{{ $menunggu_seleksi }}</h2>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-time text-warning fs-2'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Telah Dinilai</p>
                                <h2 class="fw-bold mb-0">{{ $telah_dinilai }}</h2>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-check-double text-info fs-2'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Admin, Superadmin, Pimpinan -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Total Beasiswa</p>
                                <h2 class="fw-bold mb-0">{{ $total_beasiswa }}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-award text-primary fs-2'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Total Pendaftar</p>
                                <h2 class="fw-bold mb-0">{{ $total_pendaftar }}</h2>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-group text-warning fs-2'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Pendaftar Diterima</p>
                                <h2 class="fw-bold mb-0">{{ $diterima }}</h2>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-check-circle text-success fs-2'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Dana Dicairkan</p>
                                <h2 class="fw-bold mb-0">Rp {{ number_format($dana_dicairkan, 0, ',', '.') }}</h2>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-money text-info fs-2'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-rocket me-2 text-primary'></i>
                Quick Actions
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3 mt-2">
                @if ($role === 'Superadmin')
                    <div class="col-md-3">
                        <a href="{{ route('user.index') }}" class="text-decoration-none">
                            <div class="card border border-primary border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-user-plus fs-1 text-primary mb-2'></i>
                                    <h6 class="mb-0">Manage Users</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('setting.index') }}" class="text-decoration-none">
                            <div class="card border border-success border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-cog fs-1 text-success mb-2'></i>
                                    <h6 class="mb-0">Settings</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                
                @if (in_array($role, ['Admin', 'Superadmin']))
                    <div class="col-md-3">
                        <a href="{{ route('beasiswa.index') }}" class="text-decoration-none">
                            <div class="card border border-info border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-award fs-1 text-info mb-2'></i>
                                    <h6 class="mb-0">Kelola Beasiswa</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                
                @if ($role === 'Komite')
                    <div class="col-md-3">
                        <a href="{{ route('seleksi.index') }}" class="text-decoration-none">
                            <div class="card border border-warning border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-selection fs-1 text-warning mb-2'></i>
                                    <h6 class="mb-0">Seleksi Pendaftar</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                @if ($role === 'Mahasiswa')
                    <div class="col-md-3">
                        <a href="{{ route('pendaftaran.index') }}" class="text-decoration-none">
                            <div class="card border border-primary border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-edit fs-1 text-primary mb-2'></i>
                                    <h6 class="mb-0">Daftar Beasiswa</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('akademik.profile') }}" class="text-decoration-none">
                            <div class="card border border-success border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-user-circle fs-1 text-success mb-2'></i>
                                    <h6 class="mb-0">Profil Akademik</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                @if ($role === 'Pimpinan')
                    <div class="col-md-3">
                        <a href="{{ route('seleksi.index') }}" class="text-decoration-none">
                            <div class="card border border-primary border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-bar-chart fs-1 text-primary mb-2'></i>
                                    <h6 class="mb-0">Laporan Seleksi</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('pencairan.index') }}" class="text-decoration-none">
                            <div class="card border border-success border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-wallet fs-1 text-success mb-2'></i>
                                    <h6 class="mb-0">Laporan Pencairan</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                <div class="col-md-3">
                    <a href="{{ route('dashboard.show') }}" class="text-decoration-none">
                        <div class="card border border-secondary border-opacity-25 h-100 hover-shadow">
                            <div class="card-body text-center mt-4">
                                <i class='bx bx-user fs-1 text-secondary mb-2'></i>
                                <h6 class="mb-0">My Profile</h6>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- System Information -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold">
                        <i class='bx bx-info-circle me-2 text-primary'></i>
                        System Information
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 pt-4">
                        <li class="mb-2">
                            <i class='bx bx-check-circle text-success me-2'></i>
                            <strong>Laravel Version:</strong> {{ app()->version() }}
                        </li>
                        <li class="mb-2">
                            <i class='bx bx-check-circle text-success me-2'></i>
                            <strong>PHP Version:</strong> {{ PHP_VERSION }}
                        </li>
                        <li class="mb-2">
                            <i class='bx bx-check-circle text-success me-2'></i>
                            <strong>Environment:</strong> {{ config('app.env') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 pt-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold">
                        <i class='bx bx-user me-2 text-primary'></i>
                        Your Account
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class='bx bx-envelope text-primary me-2'></i>
                            <strong>Email:</strong> {{ Auth::user()->email }}
                        </li>
                        <li class="mb-2">
                            <i class='bx bx-calendar text-primary me-2'></i>
                            <strong>Member Since:</strong> {{ Auth::user()->created_at->format('d M Y') }}
                        </li>
                        <li class="mb-2">
                            <i class='bx bx-time text-primary me-2'></i>
                            <strong>Last Updated:</strong> {{ Auth::user()->updated_at->diffForHumans() }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</x-app>
