<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-lg p-3 mb-4">
                <h5 class="fw-bold mb-3"><i class='bx bx-food-menu text-primary me-2'></i>Daftar Menu Satuan</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped w-100">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">Nama Menu</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($menus as $menu)
                                <tr>
                                    <td class="fw-bold">{{ $menu->name }}</td>
                                    <td>{{ $menu->description }}</td>
                                    <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada menu tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-lg p-3 mb-4">
                <h5 class="fw-bold mb-3"><i class='bx bx-box text-success me-2'></i>Daftar Paket Catering</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped w-100">
                        <thead class="table-success">
                            <tr>
                                <th scope="col">Nama Paket</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($packages as $package)
                                <tr>
                                    <td class="fw-bold">{{ $package->name }}</td>
                                    <td>{{ $package->description }}</td>
                                    <td>Rp {{ number_format($package->total_price, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada paket tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app>
