<x-app>
    <x-slot:title>Edit Pengumuman</x-slot:title>

    <div class="card shadow-lg p-4">
        <form action="{{ route('pengumuman.update', $pengumuman) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="beasiswa_id" class="form-label">Beasiswa</label>
                <select class="form-select @error('beasiswa_id') is-invalid @enderror" id="beasiswa_id" name="beasiswa_id" required>
                    <option value="">Pilih Beasiswa</option>
                    @foreach($beasiswas as $beasiswa)
                        <option value="{{ $beasiswa->id }}" {{ old('beasiswa_id', $pengumuman->beasiswa_id) == $beasiswa->id ? 'selected' : '' }}>
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
                <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $pengumuman->judul) }}" required>
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="konten" class="form-label">Konten Pengumuman</label>
                <textarea class="form-control @error('konten') is-invalid @enderror" id="konten" name="konten" rows="5" required>{{ old('konten', $pengumuman->konten) }}</textarea>
                @error('konten')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_tampil" class="form-label">Tanggal Tampil</label>
                <input type="date" class="form-control @error('tanggal_tampil') is-invalid @enderror" id="tanggal_tampil" name="tanggal_tampil" value="{{ old('tanggal_tampil', $pengumuman->tanggal_tampil->format('Y-m-d')) }}" required>
                @error('tanggal_tampil')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</x-app>
