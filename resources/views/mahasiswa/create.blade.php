<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row mt-3">
        <div class="col-md-9 mx-auto">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary bg-opacity-10 border-0 pt-4 pb-3 px-4">
                    <h5 class="fw-bold mb-0">
                        <i class='bx bx-user-plus me-2 text-primary'></i>
                        Form Tambah Mahasiswa Baru
                    </h5>
                    <p class="text-muted mb-0 small mt-1">Isi formulir di bawah ini untuk mendaftarkan mahasiswa baru beserta akun loginnya.</p>
                </div>
                <div class="card-body p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('akademik.store') }}" method="POST">
                        @csrf

                        {{-- SEKSI 1: AKUN PENGGUNA --}}
                        <div class="border rounded-3 p-3 mb-4">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class='bx bx-key me-1'></i> Informasi Akun Login
                            </h6>

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    placeholder="Nama lengkap mahasiswa"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}"
                                        placeholder="email@contoh.com"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Email digunakan untuk login ke sistem.</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Minimal 8 karakter"
                                            required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword" title="Tampilkan/sembunyikan password">
                                            <i class='bx bx-show' id="eyeIcon"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- SEKSI 2: DATA AKADEMIK --}}
                        <div class="border rounded-3 p-3 mb-4">
                            <h6 class="fw-bold text-success mb-3">
                                <i class='bx bx-book-open me-1'></i> Data Akademik
                            </h6>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nim" class="form-label fw-semibold">NIM <span class="text-danger">*</span></label>
                                    <input type="text" name="nim" id="nim"
                                        class="form-control @error('nim') is-invalid @enderror"
                                        value="{{ old('nim') }}"
                                        placeholder="Nomor Induk Mahasiswa"
                                        required>
                                    @error('nim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="no_hp" class="form-label fw-semibold">No. HP</label>
                                    <input type="text" name="no_hp" id="no_hp"
                                        class="form-control @error('no_hp') is-invalid @enderror"
                                        value="{{ old('no_hp') }}"
                                        placeholder="08xxxxxxxxxx">
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fakultas" class="form-label fw-semibold">Fakultas <span class="text-danger">*</span></label>
                                    <select name="fakultas" id="fakultas"
                                        class="form-select @error('fakultas') is-invalid @enderror"
                                        required>
                                        <option value="">-- Pilih Fakultas --</option>
                                        <option value="Fakultas Ilmu Komputer" {{ old('fakultas') == 'Fakultas Ilmu Komputer' ? 'selected' : '' }}>Fakultas Ilmu Komputer</option>
                                        <option value="Fakultas Ekonomi dan Bisnis" {{ old('fakultas') == 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' }}>Fakultas Ekonomi dan Bisnis</option>
                                        <option value="Fakultas Teknik" {{ old('fakultas') == 'Fakultas Teknik' ? 'selected' : '' }}>Fakultas Teknik</option>
                                        <option value="Fakultas Hukum" {{ old('fakultas') == 'Fakultas Hukum' ? 'selected' : '' }}>Fakultas Hukum</option>
                                        <option value="Fakultas Kedokteran" {{ old('fakultas') == 'Fakultas Kedokteran' ? 'selected' : '' }}>Fakultas Kedokteran</option>
                                        <option value="Fakultas MIPA" {{ old('fakultas') == 'Fakultas MIPA' ? 'selected' : '' }}>Fakultas MIPA</option>
                                        <option value="Fakultas Ilmu Sosial" {{ old('fakultas') == 'Fakultas Ilmu Sosial' ? 'selected' : '' }}>Fakultas Ilmu Sosial</option>
                                        <option value="Fakultas Pertanian" {{ old('fakultas') == 'Fakultas Pertanian' ? 'selected' : '' }}>Fakultas Pertanian</option>
                                    </select>
                                    @error('fakultas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="prodi" class="form-label fw-semibold">Program Studi <span class="text-danger">*</span></label>
                                    <input type="text" name="prodi" id="prodi"
                                        class="form-control @error('prodi') is-invalid @enderror"
                                        value="{{ old('prodi') }}"
                                        placeholder="Contoh: Teknik Informatika"
                                        required>
                                    @error('prodi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="semester" class="form-label fw-semibold">Semester Saat Ini <span class="text-danger">*</span></label>
                                    <select name="semester" id="semester"
                                        class="form-select @error('semester') is-invalid @enderror"
                                        required>
                                        <option value="">-- Pilih Semester --</option>
                                        @for($s = 1; $s <= 14; $s++)
                                            <option value="{{ $s }}" {{ old('semester') == $s ? 'selected' : '' }}>Semester {{ $s }}</option>
                                        @endfor
                                    </select>
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ipk" class="form-label fw-semibold">IPK <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="ipk" id="ipk"
                                        class="form-control @error('ipk') is-invalid @enderror"
                                        value="{{ old('ipk') }}"
                                        placeholder="Contoh: 3.75"
                                        required>
                                    @error('ipk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format desimal 0.00 – 4.00</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('akademik.index') }}" class="btn btn-secondary">
                                <i class='bx bx-arrow-back me-1'></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save me-1'></i> Simpan Mahasiswa
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.className = 'bx bx-hide';
            } else {
                passwordInput.type = 'password';
                eyeIcon.className = 'bx bx-show';
            }
        });
    </script>
    @endpush

</x-app>
