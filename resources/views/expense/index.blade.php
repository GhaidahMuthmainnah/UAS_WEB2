<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-danger text-white shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-white-50">Total Pengeluaran</h6>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($expenses->sum('amount'), 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg p-3 border-top border-danger border-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold m-0"><i class='bx bx-money-withdraw text-danger'></i> Catatan Pengeluaran Kas</h5>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class='bx bx-plus'></i> Catat Pengeluaran
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Nominal (Rp)</th>
                        <th scope="col">Terkait Pesanan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $exp)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($exp->expense_date)->format('d M Y') }}</td>
                            <td><span class="badge bg-secondary">{{ $exp->category }}</span></td>
                            <td>{{ $exp->description ?? '-' }}</td>
                            <td class="fw-bold text-danger">Rp {{ number_format($exp->amount, 0, ',', '.') }}</td>
                            <td>
                                @if($exp->order_id)
                                    <span class="badge bg-info text-dark">Order #{{ str_pad($exp->order_id, 5, '0', STR_PAD_LEFT) }}</span>
                                @else
                                    <small class="text-muted">Biaya Reguler</small>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $exp->id }}">
                                    <i class='bx bx-edit'></i> Edit
                                </button>
                                <form action="{{ route('expense.destroy', $exp) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus catatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" type="submit"><i class='bx bx-trash'></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $exp->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('expense.update', $exp) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Catatan Pengeluaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Tanggal</label>
                                                <input type="date" name="expense_date" class="form-control" value="{{ $exp->expense_date }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Kategori</label>
                                                <input type="text" name="category" class="form-control" value="{{ $exp->category }}" placeholder="Mis: Operasional, Logistik" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Nominal (Rp)</label>
                                                <input type="number" name="amount" class="form-control" value="{{ $exp->amount }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Keterangan</label>
                                                <textarea name="description" class="form-control">{{ $exp->description }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label>Atribusi ke Pesanan (Opsional)</label>
                                                <select name="order_id" class="form-select">
                                                    <option value="">-- Biaya Reguler (Bukan Pesanan) --</option>
                                                    @foreach($orders as $order)
                                                        <option value="{{ $order->id }}" @selected($order->id == $exp->order_id)>Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} - {{ $order->customer->name ?? '' }}</option>
                                                    @endforeach
                                                </select>
                                                <small class="text-muted">Kosongkan jika ini adalah biaya operasional bulanan.</small>
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
            <form action="{{ route('expense.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Catat Pengeluaran Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="date" name="expense_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Kategori</label>
                            <input type="text" name="category" class="form-control" placeholder="Mis: Operasional, Transportasi" required>
                        </div>
                        <div class="mb-3">
                            <label>Nominal (Rp)</label>
                            <input type="number" name="amount" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Keterangan</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Atribusi ke Pesanan (Opsional)</label>
                            <select name="order_id" class="form-select">
                                <option value="">-- Biaya Reguler (Bukan Pesanan) --</option>
                                @foreach($orders as $order)
                                    <option value="{{ $order->id }}">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} - {{ $order->customer->name ?? '' }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Kosongkan jika ini adalah biaya operasional reguler.</small>
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
