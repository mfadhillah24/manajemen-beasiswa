<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row g-4 mt-1">

        {{-- Info Pendaftar --}}
        <div class="col-md-5">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3">Informasi Pendaftar</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td style="width:140px" class="fw-bold">Nama</td>
                            <td>: {{ $pendaftaran->mahasiswa->user->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">NIM</td>
                            <td>: {{ $pendaftaran->mahasiswa->nim }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Program Studi</td>
                            <td>: {{ $pendaftaran->mahasiswa->program_studi }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">IPK</td>
                            <td>: <span class="badge bg-primary fs-6">{{ number_format($pendaftaran->mahasiswa->ipk, 2) }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Beasiswa</td>
                            <td>: {{ $pendaftaran->beasiswa->nama_beasiswa }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kategori</td>
                            <td>: {{ $pendaftaran->beasiswa->kategoriBeasiswa->nama_kategori }}</td>
                        </tr>
                    </table>

                    <h6 class="fw-bold mt-3 mb-2">Dokumen Diunggah ({{ $pendaftaran->dokumens->count() }} berkas)</h6>
                    @forelse($pendaftaran->dokumens as $dok)
                        <div class="d-flex justify-content-between align-items-center border rounded px-3 py-2 mb-2">
                            <span><i class='bx bx-file me-1 text-primary'></i> {{ $dok->jenis_dokumen }}</span>
                            <div>
                                @php
                                    $docBadge = match($dok->status_verifikasi) {
                                        'Pending' => 'secondary',
                                        'Valid' => 'success',
                                        'Invalid' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $docBadge }} me-2">{{ $dok->status_verifikasi }}</span>
                                <a href="{{ Storage::url($dok->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0">Lihat</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small">Tidak ada dokumen.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Form Penilaian --}}
        <div class="col-md-7">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3">Form Penilaian Komite</h5>
                    <p class="text-muted small">Formula: <strong>Skor Akhir = (Berkas × 30%) + (Wawancara × 40%) + (Prestasi × 30%)</strong></p>

                    <form action="{{ route('seleksi.store', $pendaftaran->id) }}" method="POST" class="form">
                        @csrf

                        <div class="mb-3">
                            <label for="nilai_berkas" class="form-label required fw-semibold">Nilai Berkas <small class="text-muted">(Bobot 30%)</small></label>
                            <input type="number" name="nilai_berkas" id="nilai_berkas" min="0" max="100"
                                class="form-control @error('nilai_berkas') is-invalid @enderror"
                                value="{{ old('nilai_berkas') }}" placeholder="0 - 100" required>
                            @error('nilai_berkas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nilai_wawancara" class="form-label required fw-semibold">Nilai Wawancara <small class="text-muted">(Bobot 40%)</small></label>
                            <input type="number" name="nilai_wawancara" id="nilai_wawancara" min="0" max="100"
                                class="form-control @error('nilai_wawancara') is-invalid @enderror"
                                value="{{ old('nilai_wawancara') }}" placeholder="0 - 100" required>
                            @error('nilai_wawancara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nilai_prestasi" class="form-label required fw-semibold">Nilai Prestasi <small class="text-muted">(Bobot 30%)</small></label>
                            <input type="number" name="nilai_prestasi" id="nilai_prestasi" min="0" max="100"
                                class="form-control @error('nilai_prestasi') is-invalid @enderror"
                                value="{{ old('nilai_prestasi') }}" placeholder="0 - 100" required>
                            @error('nilai_prestasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Skor Akhir (Kalkulasi Otomatis)</label>
                            <input type="text" id="preview_skor" class="form-control bg-light fw-bold text-primary" readonly placeholder="Isi nilai di atas untuk kalkulasi otomatis...">
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label fw-semibold">Catatan Komite</label>
                            <textarea name="catatan" id="catatan" rows="3"
                                class="form-control @error('catatan') is-invalid @enderror"
                                placeholder="Tulis catatan penilaian (opsional)...">{{ old('catatan') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="rekomendasi" class="form-label required fw-semibold">Rekomendasi Akhir</label>
                            <select name="rekomendasi" id="rekomendasi"
                                class="form-select @error('rekomendasi') is-invalid @enderror" required>
                                <option value="">-- Pilih Rekomendasi --</option>
                                <option value="Ya" {{ old('rekomendasi') == 'Ya' ? 'selected' : '' }}>✅ Ya – Layak Diterima</option>
                                <option value="Tidak" {{ old('rekomendasi') == 'Tidak' ? 'selected' : '' }}>❌ Tidak – Tidak Layak</option>
                            </select>
                            @error('rekomendasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('seleksi.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save me-1'></i> Simpan Penilaian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function hitungSkor() {
            const berkas = parseFloat(document.getElementById('nilai_berkas').value) || 0;
            const wawancara = parseFloat(document.getElementById('nilai_wawancara').value) || 0;
            const prestasi = parseFloat(document.getElementById('nilai_prestasi').value) || 0;
            const skor = (berkas * 0.30) + (wawancara * 0.40) + (prestasi * 0.30);
            document.getElementById('preview_skor').value = skor.toFixed(2);
        }

        document.getElementById('nilai_berkas').addEventListener('input', hitungSkor);
        document.getElementById('nilai_wawancara').addEventListener('input', hitungSkor);
        document.getElementById('nilai_prestasi').addEventListener('input', hitungSkor);
    </script>
    @endpush

</x-app>
