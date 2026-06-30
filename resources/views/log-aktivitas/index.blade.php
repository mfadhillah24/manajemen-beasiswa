<x-app>
    <x-slot:title>Log Aktivitas Sistem</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">Waktu</th>
                        <th scope="col">User</th>
                        <th scope="col">Role</th>
                        <th scope="col">Aktivitas</th>
                        <th scope="col">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $log->user->name ?? 'Sistem' }}</td>
                            <td>{{ $log->user->role ?? '-' }}</td>
                            <td><span class="badge bg-info text-dark">{{ $log->aktivitas }}</span></td>
                            <td>{{ $log->deskripsi }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
