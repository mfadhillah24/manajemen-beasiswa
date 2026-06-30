<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg border-0 mt-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Tambah Prestasi Baru</h5>

                    <form action="{{ route('prestasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_prestasi" class="form-label">Nama Prestasi</label>
                            <input type="text" class="form-control @error('nama_prestasi') is-invalid @enderror" id="nama_prestasi" name="nama_prestasi" value="{{ old('nama_prestasi') }}" required placeholder="Contoh: Juara 1 Lomba Esai Nasional">
                            @error('nama_prestasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tingkat" class="form-label">Tingkat Prestasi</label>
                                <select class="form-select @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat" required>
                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="Lokal" {{ old('tingkat') == 'Lokal' ? 'selected' : '' }}>Lokal / Regional</option>
                                    <option value="Nasional" {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="Internasional" {{ old('tingkat') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                </select>
                                @error('tingkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jenis" class="form-label">Jenis Prestasi</label>
                                <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="Akademik" {{ old('jenis') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                    <option value="Non-Akademik" {{ old('jenis') == 'Non-Akademik' ? 'selected' : '' }}>Non-Akademik</option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun') ?? date('Y') }}" required min="2000" max="{{ date('Y') + 1 }}">
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="file_sertifikat" class="form-label">Upload Sertifikat / Bukti</label>
                                <input type="file" class="form-control @error('file_sertifikat') is-invalid @enderror" id="file_sertifikat" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png" required>
                                <div class="form-text">Format: PDF, JPG, PNG. Maksimal ukuran: 2MB.</div>
                                @error('file_sertifikat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('prestasi.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Prestasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app>
