<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 border-top border-primary border-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No. Order</th>
                            <th>Pelanggan</th>
                            <th>Pesan Terakhir</th>
                            <th>Waktu</th>
                            <th class="pe-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="fw-semibold">{{ $order->customer->name ?? 'Klien' }}</td>
                            <td>
                                <span class="d-inline-block text-truncate" style="max-width: 250px;">
                                    {{ $order->chats->last()->message }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $order->chats->last()->created_at->diffForHumans() }}</small>
                            </td>
                            <td class="pe-4 text-center">
                                <a href="{{ route('chat.show', $order) }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                                    <i class='bx bx-message-dots'></i> Buka Chat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class='bx bx-chat fs-1 mb-3 text-light'></i><br>
                                Belum ada riwayat pesan dari pelanggan manapun.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app>
