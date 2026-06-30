<x-app>
    <x-slot:title>Tambah Pengumuman</x-slot:title>

    <div class="card shadow-lg p-4">
        <form action="{{ route('pengumuman.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="beasiswa_id" class="form-label">Beasiswa</label>
                <select class="form-select @error('beasiswa_id') is-invalid @enderror" id="beasiswa_id" name="beasiswa_id" required>
                    <option value="">Pilih Beasiswa</option>
                    @foreach($beasiswas as $beasiswa)
                        <option value="{{ $beasiswa->id }}" {{ old('beasiswa_id') == $beasiswa->id ? 'selected' : '' }}>
                            {{ $beasiswa->nama_beasiswa }}
                        </option>
                    @endforeach
                </select>
                @error('beasiswa_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Pengumuman</label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="konten" class="form-label">Konten Pengumuman</label>
                <textarea class="form-control @error('konten') is-invalid @enderror" id="konten" name="konten" rows="5" required>{{ old('konten') }}</textarea>
                @error('konten')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_tampil" class="form-label">Tanggal Tampil</label>
                <input type="date" class="form-control @error('tanggal_tampil') is-invalid @enderror" id="tanggal_tampil" name="tanggal_tampil" value="{{ old('tanggal_tampil') }}" required>
                @error('tanggal_tampil')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>
