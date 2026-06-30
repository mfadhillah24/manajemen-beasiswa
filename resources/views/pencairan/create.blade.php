<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg border-0 mt-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Form Input Data Pencairan Dana Beasiswa</h5>

                    <form action="{{ route('pencairan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="pendaftaran_id" class="form-label">Mahasiswa Penerima (Pendaftaran Approved)</label>
                            <select class="form-select select2-default @error('pendaftaran_id') is-invalid @enderror"
                                    id="pendaftaran_id" name="pendaftaran_id" required>
                                <option value="">-- Pilih Mahasiswa --</option>
                                @forelse($pendaftarans as $pend)
                                    <option value="{{ $pend->id }}" {{ old('pendaftaran_id') == $pend->id ? 'selected' : '' }}>
                                        {{ $pend->mahasiswa->user->name ?? '-' }} — {{ $pend->beasiswa->nama_beasiswa ?? '-' }}
                                    </option>
                                @empty
                                    <option disabled>Tidak ada pendaftaran dengan status Approved yang belum dicairkan.</option>
                                @endforelse
                            </select>
                            @error('pendaftaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nominal" class="form-label">Nominal Dana (Rp)</label>
                                <input type="number" class="form-control @error('nominal') is-invalid @enderror"
                                       id="nominal" name="nominal" value="{{ old('nominal') }}"
                                       required min="1" placeholder="Contoh: 5000000">
                                @error('nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_cair" class="form-label">Tanggal Pencairan</label>
                                <input type="date" class="form-control @error('tanggal_cair') is-invalid @enderror"
                                       id="tanggal_cair" name="tanggal_cair"
                                       value="{{ old('tanggal_cair', date('Y-m-d')) }}" required>
                                @error('tanggal_cair')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bukti_transfer" class="form-label">Upload Bukti Transfer (Opsional)</label>
                            <input type="file" class="form-control @error('bukti_transfer') is-invalid @enderror"
                                   id="bukti_transfer" name="bukti_transfer" accept=".pdf,.jpg,.jpeg,.png">
                            <div class="form-text">Format: PDF, JPG, PNG. Maks. 2MB.</div>
                            @error('bukti_transfer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('pencairan.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save me-1'></i> Simpan Data Pencairan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app>
