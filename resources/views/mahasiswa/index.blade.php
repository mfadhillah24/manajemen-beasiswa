<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-lg border-0 mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold m-0">Daftar Data Akademik Pendaftar</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="data-table">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Prodi</th>
                            <th>Semester</th>
                            <th>IPK</th>
                            <th>No HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswas as $mahasiswa)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mahasiswa->user->name ?? '-' }}</td>
                            <td><code>{{ $mahasiswa->nim }}</code></td>
                            <td>{{ $mahasiswa->prodi }}</td>
                            <td>{{ $mahasiswa->semester }}</td>
                            <td>
                                <span class="badge bg-primary fs-6">{{ number_format($mahasiswa->ipk, 2) }}</span>
                            </td>
                            <td>{{ $mahasiswa->no_hp ?? '-' }}</td>
                            <td>
                                <a href="{{ route('akademik.edit', $mahasiswa->id) }}" class="btn btn-sm btn-warning">
                                    <i class='bx bx-edit me-1'></i> Edit
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada data akademik mahasiswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app>
