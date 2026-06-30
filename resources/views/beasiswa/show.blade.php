<div class="row g-3">
    <div class="col-md-6">
        <table class="table table-borderless">
            <tr>
                <td style="width: 150px;" class="fw-bold">Nama Beasiswa</td>
                <td>: {{ $beasiswa->nama_beasiswa }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Kategori</td>
                <td>: {{ $beasiswa->kategoriBeasiswa->nama_kategori }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Syarat IPK Min.</td>
                <td>: {{ number_format($beasiswa->syarat_ipk_minimal, 2) }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Kuota Penerima</td>
                <td>: {{ $beasiswa->kuota }} orang</td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-borderless">
            <tr>
                <td style="width: 150px;" class="fw-bold">Tanggal Buka</td>
                <td>: {{ $beasiswa->tanggal_buka->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Tanggal Tutup</td>
                <td>: {{ $beasiswa->tanggal_tutup->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Status</td>
                <td>: 
                    <span class="badge bg-{{ $beasiswa->status == 'Aktif' ? 'success' : 'danger' }}">
                        {{ $beasiswa->status }}
                    </span>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-12">
        <hr>
        <h6 class="fw-bold">Deskripsi & Ketentuan:</h6>
        <p class="text-muted" style="white-space: pre-line;">{{ $beasiswa->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
    </div>
</div>
