<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg border-0 mt-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Edit Prestasi</h5>

                    <form action="{{ route('prestasi.update', $prestasi->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_prestasi" class="form-label">Nama Prestasi</label>
                            <input type="text" class="form-control @error('nama_prestasi') is-invalid @enderror" id="nama_prestasi" name="nama_prestasi" value="{{ old('nama_prestasi', $prestasi->nama_prestasi) }}" required>
                            @error('nama_prestasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tingkat" class="form-label">Tingkat Prestasi</label>
                                <select class="form-select @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat" required>
                                    <option value="Lokal" {{ old('tingkat', $prestasi->tingkat) == 'Lokal' ? 'selected' : '' }}>Lokal / Regional</option>
                                    <option value="Nasional" {{ old('tingkat', $prestasi->tingkat) == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="Internasional" {{ old('tingkat', $prestasi->tingkat) == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                </select>
                                @error('tingkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jenis" class="form-label">Jenis Prestasi</label>
                                <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
                                    <option value="Akademik" {{ old('jenis', $prestasi->jenis) == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                    <option value="Non-Akademik" {{ old('jenis', $prestasi->jenis) == 'Non-Akademik' ? 'selected' : '' }}>Non-Akademik</option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', $prestasi->tahun) }}" required min="2000" max="{{ date('Y') + 1 }}">
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="file_sertifikat" class="form-label">Upload Ulang Sertifikat (Opsional)</label>
                                <input type="file" class="form-control @error('file_sertifikat') is-invalid @enderror" id="file_sertifikat" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text">Biarkan kosong jika tidak ingin mengubah sertifikat. Format: PDF, JPG, PNG (Max 2MB).</div>
                                @if($prestasi->file_sertifikat)
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $prestasi->file_sertifikat) }}" target="_blank" class="badge bg-secondary text-decoration-none">
                                            <i class='bx bx-file'></i> Lihat Sertifikat Saat Ini
                                        </a>
                                    </div>
                                @endif
                                @error('file_sertifikat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('prestasi.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app>
