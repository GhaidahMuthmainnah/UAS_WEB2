<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <!-- Rincian Acara & Klien -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4 border-0 border-top border-primary border-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Informasi Akun</h5>
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
        </div>

        <!-- Rincian Pesanan (Invoice) -->
        <div class="col-md-8">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Faktur Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h5>
                    <div>
                        @if($order->status == 'Paid')
                            <span class="badge bg-success fs-6 px-3 py-2"><i class="bx bx-check me-1"></i>LUNAS</span>
                        @elseif($order->status == 'Pending')
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2"><i class="bx bx-time me-1"></i>PENDING</span>
                        @else
                            <span class="badge bg-danger fs-6 px-3 py-2"><i class="bx bx-x me-1"></i>CANCELLED</span>
                        @endif
                    </div>
                </div>
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
            <a href="{{ route('myorder.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali ke Riwayat Pesanan
            </a>
        </div>
    </div>
</x-app>
