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

    <!-- Testimoni Klien -->
    <div class="mt-5 mb-4">
        <h4 class="fw-bold mb-4 text-center"><i class='bx bxs-quote-alt-left text-primary'></i> Apa Kata Klien Kami?</h4>
        <div class="row g-4">
            @foreach($testimonials as $testi)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 bg-light">
                    <div class="card-body">
                        <div class="text-warning mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testi->rating)
                                    <i class='bx bxs-star'></i>
                                @else
                                    <i class='bx bx-star'></i>
                                @endif
                            @endfor
                        </div>
                        <p class="fst-italic text-secondary">"{{ $testi->review }}"</p>
                        <h6 class="fw-bold mb-0 mt-3">- {{ $testi->customer->name ?? 'Klien' }}</h6>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app>
