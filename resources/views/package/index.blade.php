<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('package.create') }}" role="button">Tambah Paket</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Paket</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($packages as $package)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $package->name }}</td>
                            <td>{{ Str::limit($package->description, 50) }}</td>
                            <td>Rp {{ number_format($package->total_price, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('package.edit', $package) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <form action="{{ route('package.destroy', $package) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus paket ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
