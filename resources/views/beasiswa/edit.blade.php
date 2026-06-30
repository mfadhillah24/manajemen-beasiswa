<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('beasiswa.update', $beasiswa) }}" method="post" class="form">
            @csrf
            @method('put')

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_beasiswa" class="form-label required">Nama Beasiswa</label>
                        <input class="form-control @error('nama_beasiswa') is-invalid @enderror" type="text" id="nama_beasiswa"
                            name="nama_beasiswa" required value="{{ old('nama_beasiswa', $beasiswa->nama_beasiswa) }}">
                        @error('nama_beasiswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kategori_beasiswa_id" class="form-label required">Kategori Beasiswa</label>
                        <select class="form-select select2-default @error('kategori_beasiswa_id') is-invalid @enderror" id="kategori_beasiswa_id"
                            name="kategori_beasiswa_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('kategori_beasiswa_id', $beasiswa->kategori_beasiswa_id) == $kategori->id)>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_beasiswa_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="syarat_ipk_minimal" class="form-label required">Syarat IPK Minimal</label>
                            <input class="form-control @error('syarat_ipk_minimal') is-invalid @enderror" type="number" step="0.01" min="0" max="4" id="syarat_ipk_minimal"
                                name="syarat_ipk_minimal" required value="{{ old('syarat_ipk_minimal', number_format($beasiswa->syarat_ipk_minimal, 2)) }}">
                            @error('syarat_ipk_minimal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kuota" class="form-label required">Kuota Penerima</label>
                            <input class="form-control @error('kuota') is-invalid @enderror" type="number" min="1" id="kuota"
                                name="kuota" required value="{{ old('kuota', $beasiswa->kuota) }}">
                            @error('kuota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_buka" class="form-label required">Tanggal Buka</label>
                            <input class="form-control @error('tanggal_buka') is-invalid @enderror" type="date" id="tanggal_buka"
                                name="tanggal_buka" required value="{{ old('tanggal_buka', $beasiswa->tanggal_buka->format('Y-m-d')) }}">
                            @error('tanggal_buka')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_tutup" class="form-label required">Tanggal Tutup</label>
                            <input class="form-control @error('tanggal_tutup') is-invalid @enderror" type="date" id="tanggal_tutup"
                                name="tanggal_tutup" required value="{{ old('tanggal_tutup', $beasiswa->tanggal_tutup->format('Y-m-d')) }}">
                            @error('tanggal_tutup')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label required">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="Aktif" @selected(old('status', $beasiswa->status) == 'Aktif')>Aktif</option>
                            <option value="Nonaktif" @selected(old('status', $beasiswa->status) == 'Nonaktif')>Nonaktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi & Ketentuan</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $beasiswa->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('beasiswa.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>

        </form>

    </div>

</x-app>
