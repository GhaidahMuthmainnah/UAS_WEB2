<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('chat.index') }}" class="btn btn-secondary mb-3 shadow-sm rounded-pill px-3">
                <i class='bx bx-arrow-back'></i> Kembali ke Pusat Pesan
            </a>

            <!-- Ruang Diskusi / Chat (Admin POV) -->
            <div class="card shadow-lg border-0 mb-4 rounded-4">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-message-dots text-primary fs-3 me-2'></i>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $order->customer->name ?? 'Pelanggan' }}</h5>
                            <small class="text-muted">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} - {{ $order->event->event_name ?? 'Acara' }}</small>
                        </div>
                    </div>
                    <a href="{{ route('order.show', $order) }}" class="btn btn-outline-info btn-sm rounded-pill shadow-sm">Lihat Detail Order</a>
                </div>
                
                <div class="card-body p-4" style="height: 500px; overflow-y: auto; background-color: #f8f9fa;">
                    @forelse($order->chats as $chat)
                        @if($chat->sender_id == Auth::id() || in_array($chat->sender->role, ['Superadmin', 'Admin', 'Staff']))
                            <!-- Chat Admin (Kanan) -->
                            <div class="d-flex justify-content-end mb-3">
                                <div class="bg-primary text-white p-3 rounded-4 rounded-top-right-0 shadow-sm" style="max-width: 75%; border-top-right-radius: 0;">
                                    <small class="text-white-50 fw-bold d-block mb-1">{{ $chat->sender->name }} (Anda/Staff)</small>
                                    <p class="mb-1">{{ $chat->message }}</p>
                                    <small class="text-white-50 d-block text-end" style="font-size: 0.7rem;">{{ $chat->created_at->format('H:i') }}</small>
                                </div>
                            </div>
                        @else
                            <!-- Chat Klien (Kiri) -->
                            <div class="d-flex justify-content-start mb-3">
                                <div class="bg-white border p-3 rounded-4 rounded-top-left-0 shadow-sm" style="max-width: 75%; border-top-left-radius: 0;">
                                    <small class="fw-bold text-dark d-block mb-1">{{ $chat->sender->name }} (Pelanggan)</small>
                                    <p class="mb-1 text-dark">{{ $chat->message }}</p>
                                    <small class="text-muted d-block text-end" style="font-size: 0.7rem;">{{ $chat->created_at->format('H:i') }}</small>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center text-muted h-100 d-flex flex-column justify-content-center align-items-center">
                            <i class='bx bx-chat fs-1 mb-2 text-light'></i>
                            <p>Belum ada pesan dari Pelanggan.</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="card-footer bg-white border-top p-3">
                    <form action="{{ route('chat.store', $order) }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <input type="text" name="message" class="form-control rounded-pill px-4" placeholder="Ketik balasan Anda di sini..." required autocomplete="off">
                        <button type="submit" class="btn btn-primary rounded-circle shadow-sm" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;"><i class='bx bxs-send m-0 fs-5'></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app>
