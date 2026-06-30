<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row mt-3">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4 text-center">
                    
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('niceadmin/img/noprofil.png') }}" 
                        alt="Profile" class="rounded-circle mb-3 shadow" style="width: 120px; height: 120px; object-fit: cover;">
                    
                    <h4 class="fw-bold">{{ Auth::user()->name }}</h4>
                    <p class="text-muted mb-4">{{ Auth::user()->email }}</p>

                    @if(!$mahasiswa)
                        <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                            <i class='bx bx-error-circle fs-3 me-2'></i>
                            <div>
                                Data akademik Anda belum terdaftar di sistem. Silakan hubungi Administrator untuk mendaftarkan NIM dan IPK Anda agar dapat mendaftar beasiswa.
                            </div>
                        </div>
                    @else
                        <div class="row text-start mt-4 g-4">
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <small class="text-muted d-block mb-1">Nomor Induk Mahasiswa (NIM)</small>
                                    <h5 class="fw-bold m-0"><i class='bx bx-id-card text-primary me-2'></i> {{ $mahasiswa->nim }}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <small class="text-muted d-block mb-1">Indeks Prestasi Kumulatif (IPK)</small>
                                    <h5 class="fw-bold m-0 text-primary"><i class='bx bx-bar-chart-alt-2 me-2'></i> {{ number_format($mahasiswa->ipk, 2) }}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <small class="text-muted d-block mb-1">Program Studi & Fakultas</small>
                                    <h6 class="fw-bold m-0"><i class='bx bxs-graduation text-primary me-2'></i> {{ $mahasiswa->prodi }}</h6>
                                    <small class="text-muted ms-4 ps-1">{{ $mahasiswa->fakultas }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <small class="text-muted d-block mb-1">Semester Aktif</small>
                                    <h5 class="fw-bold m-0"><i class='bx bx-time-five text-primary me-2'></i> Semester {{ $mahasiswa->semester }}</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 border rounded bg-light d-flex align-items-center">
                                    <i class='bx bx-phone-call text-primary fs-4 me-3'></i>
                                    <div>
                                        <small class="text-muted d-block mb-1">Nomor Handphone (WhatsApp)</small>
                                        <h6 class="fw-bold m-0">{{ $mahasiswa->no_hp ?? 'Belum diatur' }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top text-muted small text-start">
                            <i class='bx bx-info-circle me-1'></i> Data akademik ini digunakan sebagai syarat verifikasi otomatis saat mendaftar beasiswa. Jika terdapat kesalahan data (seperti IPK yang belum di-update), silakan hubungi bagian Akademik atau Administrator sistem.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</x-app>
