<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <!-- Rincian Acara & Klien -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4 border-0 border-top border-primary border-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Informasi Klien</h5>
                    <div class="mb-3">
                        <small class="text-muted d-block">Nama</small>
                        <span class="fw-semibold">{{ $order->customer->name ?? '-' }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Telepon</small>
                        <span>{{ $order->customer->phone ?? '-' }}</span>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted d-block">Email</small>
                        <span>{{ $order->customer->email ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4 border-0 border-top border-info border-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Detail Acara</h5>
                    <div class="mb-3">
                        <small class="text-muted d-block">Nama Acara</small>
                        <span class="fw-semibold">{{ $order->event->event_name ?? '-' }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Tanggal Acara</small>
                        <span>{{ $order->event ? \Carbon\Carbon::parse($order->event->event_date)->format('d M Y H:i') : '-' }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Jumlah Tamu</small>
                        <span>{{ $order->event->num_guests ?? 0 }} Pax</span>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted d-block">Lokasi</small>
                        <span>{{ $order->event->location ?? '-' }}</span>
                    </div>
                </div>
            </div>
            
            @if(in_array(Auth::user()->role, ['Superadmin', 'Admin']))
            <div class="card shadow-sm mb-4 border-0 border-top border-warning border-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Ubah Status</h5>
                    <form action="{{ route('order.status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="input-group">
                            <select name="status" class="form-select">
                                <option value="Pending" @selected($order->status == 'Pending')>Pending</option>
                                <option value="Paid" @selected($order->status == 'Paid')>Paid</option>
                                <option value="Cancelled" @selected($order->status == 'Cancelled')>Cancelled</option>
                            </select>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Validasi Pembayaran (Admin POV) -->
            <div class="card shadow-sm mb-4 border-0 border-top border-success border-4 d-print-none">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Validasi Pembayaran</h5>
                    @php
                        $totalPaid = $order->payments()->where('status', 'Verified')->sum('amount');
                        $sisa = $order->total_amount - $totalPaid;
                    @endphp
                    
                    <div class="d-flex justify-content-between mb-2 mt-3">
                        <span class="text-muted">Terkonfirmasi:</span>
                        <span class="fw-bold text-success">Rp {{ number_format($totalPaid, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span class="text-muted">Sisa Tagihan:</span>
                        <span class="fw-bold text-danger">Rp {{ number_format($sisa, 0, ',', '.') }}</span>
                    </div>

                    @if($order->payments->count() > 0)
                        <div class="mt-3">
                            <ul class="list-group list-group-flush small">
                                @foreach($order->payments as $pay)
                                <li class="list-group-item px-0">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-bold text-primary">{{ $pay->type }}</span>
                                        <span class="fw-semibold">Rp {{ number_format($pay->amount, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">{{ $pay->created_at->format('d/m/Y H:i') }}</span>
                                        @if($pay->status == 'Verified')
                                            <span class="badge bg-success">Verified</span>
                                        @elseif($pay->status == 'Rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </div>
                                    <a href="{{ Storage::url($pay->payment_proof) }}" target="_blank" class="btn btn-outline-info btn-sm w-100 mb-2">Lihat Bukti Transfer</a>
                                    
                                    @if($pay->status == 'Pending')
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('payment.verify', $pay) }}" method="POST" class="w-50">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="Verified">
                                            <button type="submit" class="btn btn-success btn-sm w-100"><i class='bx bx-check'></i> Terima</button>
                                        </form>
                                        <form action="{{ route('payment.verify', $pay) }}" method="POST" class="w-50">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="Rejected">
                                            <button type="submit" class="btn btn-danger btn-sm w-100"><i class='bx bx-x'></i> Tolak</button>
                                        </form>
                                    </div>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <p class="text-muted small mt-2 text-center mb-0">Belum ada data pembayaran masuk.</p>
                    @endif
                </div>
            </div>
            @endif
        </div>
        <!-- Rincian Pesanan (Invoice) -->
        <div class="col-md-8">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Rincian Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h5>
                    <div class="d-flex gap-2">
                        <button onclick="window.print()" class="btn btn-outline-danger btn-sm d-print-none shadow-sm fw-bold">
                            <i class='bx bxs-file-pdf'></i> Export PDF
                        </button>
                        @if($order->status == 'Paid')
                            <span class="badge bg-success fs-6 px-3 py-2"><i class="bx bx-check me-1"></i>LUNAS</span>
                        @elseif($order->status == 'Pending')
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2"><i class="bx bx-time me-1"></i>PENDING</span>
                        @else
                            <span class="badge bg-danger fs-6 px-3 py-2"><i class="bx bx-x me-1"></i>CANCELLED</span>
                        @endif
                    </div>
                </div>

                <!-- Custom CSS Khusus Cetak -->
                <style>
                    @media print {
                        body * {
                            visibility: hidden;
                        }
                        #main, #main * {
                            visibility: visible;
                        }
                        #main {
                            position: absolute;
                            left: 0;
                            top: 0;
                            width: 100%;
                            margin: 0 !important;
                            padding: 0 !important;
                        }
                        .d-print-none, .sidebar, .header {
                            display: none !important;
                        }
                        .card {
                            border: none !important;
                            box-shadow: none !important;
                        }
                        .col-md-4, .col-md-8 {
                            width: 100% !important;
                            flex: 0 0 100% !important;
                            max-width: 100% !important;
                        }
                    }
                </style>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Item</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end pe-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="ps-4">
                                        @if($item->menu_id)
                                            <span class="fw-semibold">{{ $item->menu->name ?? 'Menu Dihapus' }}</span><br>
                                            <small class="text-muted">Menu Satuan</small>
                                        @elseif($item->package_id)
                                            <span class="fw-semibold text-success">{{ $item->package->name ?? 'Paket Dihapus' }}</span><br>
                                            <small class="text-muted">Paket Katering</small>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">{{ $item->quantity }}</td>
                                    <td class="text-end align-middle">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="text-end align-middle pe-4 fw-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold pt-3 pb-3">TOTAL KESELURUHAN</td>
                                    <td class="text-end fw-bold text-primary fs-5 pe-4 pt-3 pb-3">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <a href="{{ route('order.index') }}" class="btn btn-secondary d-print-none mb-4">
                <i class="bx bx-arrow-back me-1"></i> Kembali ke Daftar Pesanan
            </a>

        </div>
    </div>
</x-app>
