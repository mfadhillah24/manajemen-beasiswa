<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row mt-3">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3">Form Edit Data Akademik</h5>
                    
                    <form action="{{ route('akademik.update', $mahasiswa->id) }}" method="POST" class="form">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label text-muted">Nama Mahasiswa</label>
                            <input type="text" class="form-control bg-light" value="{{ $mahasiswa->user->name }}" readonly disabled>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nim" class="form-label required">NIM</label>
                                <input type="text" name="nim" id="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim', $mahasiswa->nim) }}" required>
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="no_hp" class="form-label">Nomor HP</label>
                                <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $mahasiswa->no_hp) }}">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fakultas" class="form-label required">Fakultas</label>
                                <input type="text" name="fakultas" id="fakultas" class="form-control @error('fakultas') is-invalid @enderror" value="{{ old('fakultas', $mahasiswa->fakultas) }}" required>
                                @error('fakultas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="prodi" class="form-label required">Program Studi</label>
                                <input type="text" name="prodi" id="prodi" class="form-control @error('prodi') is-invalid @enderror" value="{{ old('prodi', $mahasiswa->prodi) }}" required>
                                @error('prodi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="semester" class="form-label required">Semester Saat Ini</label>
                                <input type="number" name="semester" id="semester" min="1" class="form-control @error('semester') is-invalid @enderror" value="{{ old('semester', $mahasiswa->semester) }}" required>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="ipk" class="form-label required">IPK</label>
                                <input type="number" step="0.01" min="0" max="4.00" name="ipk" id="ipk" class="form-control fw-bold text-primary @error('ipk') is-invalid @enderror" value="{{ old('ipk', $mahasiswa->ipk) }}" required>
                                @error('ipk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Gunakan format desimal, contoh: 3.75</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('akademik.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save me-1'></i> Perbarui Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app>
