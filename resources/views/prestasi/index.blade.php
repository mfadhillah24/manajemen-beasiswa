<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-lg border-0 mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold m-0">Portofolio Prestasi Saya</h5>
                <a href="{{ route('prestasi.create') }}" class="btn btn-primary">
                    <i class='bx bx-plus me-1'></i> Tambah Prestasi
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Prestasi</th>
                            <th>Tingkat</th>
                            <th>Jenis</th>
                            <th>Tahun</th>
                            <th>Sertifikat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasis as $prestasi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $prestasi->nama_prestasi }}</td>
                            <td>
                                @if($prestasi->tingkat == 'Internasional')
                                    <span class="badge bg-danger">{{ $prestasi->tingkat }}</span>
                                @elseif($prestasi->tingkat == 'Nasional')
                                    <span class="badge bg-warning text-dark">{{ $prestasi->tingkat }}</span>
                                @else
                                    <span class="badge bg-info text-dark">{{ $prestasi->tingkat }}</span>
                                @endif
                            </td>
                            <td>{{ $prestasi->jenis }}</td>
                            <td>{{ $prestasi->tahun }}</td>
                            <td>
                                @if($prestasi->file_sertifikat)
                                    <a href="{{ asset('storage/' . $prestasi->file_sertifikat) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class='bx bx-file'></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('prestasi.edit', $prestasi->id) }}" class="btn btn-sm btn-warning">
                                        <i class='bx bx-edit'></i> Edit
                                    </a>
                                    <form action="{{ route('prestasi.destroy', $prestasi->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus prestasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class='bx bx-trash'></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Anda belum mencatat prestasi apapun. Tambahkan prestasi Anda untuk meningkatkan peluang lulus seleksi beasiswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app>
