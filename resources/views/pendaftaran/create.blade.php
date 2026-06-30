<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row g-4">
        <div class="col-md-6">
            <!-- Informasi Beasiswa -->
            <div class="card shadow-lg p-4 border-0 h-100">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Detail Program Beasiswa</h5>
                <table class="table table-borderless">
                    <tr>
                        <td style="width: 150px;" class="fw-bold">Nama Beasiswa</td>
                        <td>: {{ $beasiswa->nama_beasiswa }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Kategori</td>
                        <td>: {{ $beasiswa->kategoriBeasiswa->nama_kategori }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Syarat IPK Min.</td>
                        <td>: <span class="badge bg-primary">{{ number_format($beasiswa->syarat_ipk_minimal, 2) }}</span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Kuota Penerima</td>
                        <td>: {{ $beasiswa->kuota }} orang</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Batas Pendaftaran</td>
                        <td>: {{ $beasiswa->tanggal_tutup->format('d F Y') }}</td>
                    </tr>
                </table>
                <hr>
                <h6 class="fw-bold">Deskripsi & Ketentuan:</h6>
                <p class="text-muted" style="white-space: pre-line;">{{ $beasiswa->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            </div>
        </div>

        <div class="col-md-6">
            <!-- Konfirmasi Pendaftar -->
            <div class="card shadow-lg p-4 border-0 h-100 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Konfirmasi Data Akademik Anda</h5>
                    <div class="alert alert-info border-0 shadow-sm mb-4">
                        Data di bawah ini disinkronkan secara otomatis dengan Sistem Informasi Akademik Kampus Unitama.
                    </div>
                    <table class="table table-borderless">
                        <tr>
                            <td style="width: 150px;" class="fw-bold">Nama Lengkap</td>
                            <td>: {{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">NIM</td>
                            <td>: {{ $mahasiswa->nim }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Program Studi</td>
                            <td>: {{ $mahasiswa->prodi }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Fakultas</td>
                            <td>: {{ $mahasiswa->fakultas }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Semester</td>
                            <td>: Semester {{ $mahasiswa->semester }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">IPK Terakhir</td>
                            <td>: <strong class="text-success">{{ number_format($mahasiswa->ipk, 2) }}</strong></td>
                        </tr>
                    </table>
                </div>

                <form action="{{ route('pendaftaran.store') }}" method="post" class="mt-4">
                    @csrf
                    <input type="hidden" name="beasiswa_id" value="{{ $beasiswa->id }}">

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="confirm-check" required>
                        <label class="form-check-input-label small text-muted" for="confirm-check">
                            Saya menyatakan bahwa data akademik di atas adalah benar dan saya bersedia mengikuti seluruh proses seleksi Beasiswa Kampus Unitama.
                        </label>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('pendaftaran.index') }}" class="btn btn-warning me-1">Batal</a>
                        <button type="submit" class="btn btn-primary">Kirim Pendaftaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app>
