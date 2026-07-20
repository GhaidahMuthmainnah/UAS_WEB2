<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold m-0"><i class='bx bx-box text-primary'></i> Daftar Bahan Baku</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class='bx bx-plus'></i> Tambah Bahan
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Bahan</th>
                        <th scope="col">Harga Modal (Satuan)</th>
                        <th scope="col">Stok Gudang</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ingredients as $ing)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $ing->name }}</td>
                            <td>Rp {{ number_format($ing->cost_per_unit, 0, ',', '.') }} <small class="text-muted">/ {{ $ing->unit }}</small></td>
                            <td>
                                @if($ing->stock_quantity <= 10)
                                    <span class="badge bg-danger">{{ $ing->stock_quantity }} {{ $ing->unit }} (Menipis)</span>
                                @else
                                    <span class="badge bg-success">{{ $ing->stock_quantity }} {{ $ing->unit }}</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $ing->id }}">
                                    <i class='bx bx-edit'></i> Edit
                                </button>
                                <form action="{{ route('ingredient.destroy', $ing) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus bahan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit"><i class='bx bx-trash'></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $ing->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('ingredient.update', $ing) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Bahan Baku</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Nama Bahan</label>
                                                <input type="text" name="name" class="form-control" value="{{ $ing->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Satuan (Mis: kg, liter)</label>
                                                <input type="text" name="unit" class="form-control" value="{{ $ing->unit }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Harga per Satuan (Rp)</label>
                                                <input type="number" name="cost_per_unit" class="form-control" value="{{ $ing->cost_per_unit }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Stok Saat Ini</label>
                                                <input type="number" name="stock_quantity" class="form-control" value="{{ $ing->stock_quantity }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('ingredient.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Bahan Baku Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Bahan</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Satuan (Mis: kg, liter)</label>
                            <input type="text" name="unit" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Harga per Satuan (Rp)</label>
                            <input type="number" name="cost_per_unit" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Stok Awal</label>
                            <input type="number" name="stock_quantity" class="form-control" value="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app>
