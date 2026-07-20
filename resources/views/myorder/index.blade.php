<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tanggal Order</th>
                        <th scope="col">Acara (Tgl)</th>
                        <th scope="col">Total (Rp)</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                            <td>
                                {{ $order->event->event_name ?? '-' }} 
                                <br><small class="text-muted">{{ $order->event ? \Carbon\Carbon::parse($order->event->event_date)->format('d M Y') : '' }}</small>
                            </td>
                            <td class="fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                @if($order->status == 'Paid')
                                    <span class="badge bg-success"><i class="bx bx-check me-1"></i>Paid</span>
                                @elseif($order->status == 'Pending')
                                    <span class="badge bg-warning text-dark"><i class="bx bx-time me-1"></i>Pending</span>
                                @else
                                    <span class="badge bg-danger"><i class="bx bx-x me-1"></i>Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('myorder.show', $order) }}" class="btn btn-info btn-sm text-white">
                                    <i class='bx bx-show'></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Anda belum memiliki riwayat pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app>
