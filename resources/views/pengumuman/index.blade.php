<x-app>
    <x-slot:title>Pengumuman</x-slot:title>

    <div class="card shadow-lg p-3">
        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Pimpinan'))
            <div class="mb-3">
                <a class="btn btn-primary" href="{{ route('pengumuman.create') }}" role="button">Tambah Pengumuman</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped w-100" id="data-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Beasiswa</th>
                            <th scope="col">Tanggal Tampil</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengumumans as $pengumuman)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pengumuman->judul }}</td>
                                <td>{{ $pengumuman->beasiswa->nama_beasiswa ?? '-' }}</td>
                                <td>{{ $pengumuman->tanggal_tampil->translatedFormat('d F Y') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('pengumuman.edit', $pengumuman) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                            <i class='bx bx-edit-alt'></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-route="{{ route('pengumuman.destroy', $pengumuman) }}" title="Hapus">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- View untuk Mahasiswa -->
            <div class="row">
                @forelse($pengumumans as $pengumuman)
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 border-primary shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">{{ $pengumuman->judul }}</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="text-muted mb-2"><i class='bx bx-calendar'></i> {{ $pengumuman->tanggal_tampil->translatedFormat('d F Y') }} | <i class='bx bx-award'></i> {{ $pengumuman->beasiswa->nama_beasiswa ?? '-' }}</h6>
                                <p class="card-text">{{ $pengumuman->konten }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">Belum ada pengumuman saat ini.</div>
                    </div>
                @endforelse
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            $('#data-table').on('click', '.btn-delete', function() {
                $('#form-delete').attr('action', $(this).data('route'))
            })
        </script>
    @endpush
</x-app>
