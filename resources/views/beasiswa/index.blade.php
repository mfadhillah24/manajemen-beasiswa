<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('beasiswa.create') }}" role="button">Tambah Beasiswa</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Beasiswa</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Syarat IPK</th>
                        <th scope="col">Kuota</th>
                        <th scope="col">Periode</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($beasiswas as $beasiswa)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $beasiswa->nama_beasiswa }}</td>
                            <td>{{ $beasiswa->kategoriBeasiswa->nama_kategori }}</td>
                            <td>{{ number_format($beasiswa->syarat_ipk_minimal, 2) }}</td>
                            <td>{{ $beasiswa->kuota }}</td>
                            <td>{{ $beasiswa->tanggal_buka->translatedFormat('d F Y') }} - {{ $beasiswa->tanggal_tutup->translatedFormat('d F Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $beasiswa->status == 'Aktif' ? 'success' : 'danger' }}">
                                    {{ $beasiswa->status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <button type="button" class="btn btn-info btn-sm btn-detail text-white"
                                        data-route="{{ route('beasiswa.show', $beasiswa) }}" title="Detail">
                                        <i class='bx bx-show'></i>
                                    </button>
                                    <a href="{{ route('beasiswa.edit', $beasiswa) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                        <i class='bx bx-edit-alt'></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal" data-route="{{ route('beasiswa.destroy', $beasiswa) }}" title="Hapus">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    @push('modals')
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Beasiswa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-detail">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endpush

    @push('scripts')
        <script>
            $('#data-table').on('click', '.btn-delete', function() {
                $('#form-delete').attr('action', $(this).data('route'))
            })

            $('#data-table').on('click', '.btn-detail', function() {
                Swal.fire({
                    title: 'Memuat...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $('#modal-detail').load($(this).data('route'), function(response, status, xhr) {
                    if (status == "success") {
                        setTimeout(() => {
                            Swal.close();
                            $('#detailModal').modal('show');
                        }, 1000);
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Gagal memuat data",
                            icon: "error"
                        });
                    }
                });
            })
        </script>
    @endpush

</x-app>
