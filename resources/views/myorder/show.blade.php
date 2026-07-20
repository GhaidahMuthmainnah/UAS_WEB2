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

            @if($order->deliverySchedule)
            <div class="card shadow-sm mb-4 border-0 border-top border-warning border-4">
                <div class="card-body bg-light">
                    <h5 class="card-title fw-bold"><i class='bx bxs-truck'></i> Lacak Pengiriman</h5>
                    <div class="mt-3 text-center">
                        @if($order->deliverySchedule->status == 'Scheduled')
                            <span class="badge bg-secondary text-white fs-6 px-3 py-2 w-100 mb-2">Terjadwal</span>
                        @elseif($order->deliverySchedule->status == 'EnRoute')
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2 w-100 mb-2 shadow-sm"><i class='bx bx-loader bx-spin'></i> Sedang Di Jalan</span>
                        @elseif($order->deliverySchedule->status == 'Delivered')
                            <span class="badge bg-success text-white fs-6 px-3 py-2 w-100 mb-2 shadow-sm"><i class='bx bx-check-double'></i> Sudah Sampai</span>
                        @endif
                    </div>
                    <div class="mb-2 mt-3">
                        <small class="text-muted d-block">Kurir / Driver</small>
                        <span class="fw-semibold">{{ $order->deliverySchedule->driver_name ?? 'Belum Ditentukan' }}</span>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted d-block">Estimasi Pengantaran</small>
                        <span>{{ \Carbon\Carbon::parse($order->deliverySchedule->delivery_time)->format('d M Y H:i') }} WIB</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Riwayat Pembayaran (Customer POV) -->
            <div class="card shadow-sm mb-4 border-0 border-top border-success border-4 d-print-none">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Status Pembayaran</h5>
                    @php
                        $totalPaid = $order->payments()->where('status', 'Verified')->sum('amount');
                        $sisa = $order->total_amount - $totalPaid;
                    @endphp
                    
                    <div class="d-flex justify-content-between mb-2 mt-3">
                        <span class="text-muted">Total Terbayar:</span>
                        <span class="fw-bold text-success">Rp {{ number_format($totalPaid, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span class="text-muted">Sisa Tagihan:</span>
                        <span class="fw-bold text-danger">Rp {{ number_format($sisa, 0, ',', '.') }}</span>
                    </div>
                    
                    <!-- Tombol Modal Bayar -->
                    @if($sisa > 0 && $order->status != 'Cancelled')
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#payModal">
                            <i class='bx bx-credit-card'></i> Bayar Tagihan (DP / Lunas)
                        </button>
                    @endif

                    <!-- List Pembayaran Sebelumnya -->
                    @if($order->payments->count() > 0)
                        <div class="mt-4">
                            <h6 class="fw-bold fs-6 border-bottom pb-2">Riwayat Transaksi</h6>
                            <ul class="list-group list-group-flush small">
                                @foreach($order->payments as $pay)
                                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="d-block fw-semibold">{{ $pay->type }}</span>
                                        <span class="text-muted">{{ $pay->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block">Rp {{ number_format($pay->amount, 0, ',', '.') }}</span>
                                        @if($pay->status == 'Verified')
                                            <span class="badge bg-success">Verified</span>
                                        @elseif($pay->status == 'Rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Rincian Pesanan (Invoice) -->
        <div class="col-md-8">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Faktur Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h5>
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
            <a href="{{ route('myorder.index') }}" class="btn btn-secondary d-print-none mb-4">
                <i class="bx bx-arrow-back me-1"></i> Kembali ke Riwayat Pesanan
            </a>

            <!-- Ruang Diskusi / Chat (Customer POV) -->
            <div class="card shadow-sm border-0 d-print-none mb-4">
                <div class="card-header bg-white py-3 d-flex align-items-center">
                    <i class='bx bx-message-dots text-primary fs-4 me-2'></i>
                    <h5 class="mb-0 fw-bold">Ruang Diskusi Pesanan</h5>
                </div>
                <div class="card-body p-4" style="height: 350px; overflow-y: auto; background-color: #f8f9fa;">
                    @forelse($order->chats as $chat)
                        @if($chat->sender_id == Auth::id())
                            <!-- Chat Klien (Kanan) -->
                            <div class="d-flex justify-content-end mb-3">
                                <div class="bg-primary text-white p-3 rounded-3 shadow-sm" style="max-width: 75%;">
                                    <p class="mb-1">{{ $chat->message }}</p>
                                    <small class="text-white-50 d-block text-end" style="font-size: 0.7rem;">{{ $chat->created_at->format('H:i') }}</small>
                                </div>
                            </div>
                        @else
                            <!-- Chat Admin/Staff (Kiri) -->
                            <div class="d-flex justify-content-start mb-3">
                                <div class="bg-white border p-3 rounded-3 shadow-sm" style="max-width: 75%;">
                                    <small class="fw-bold text-dark d-block mb-1">{{ $chat->sender->name }} (Staff)</small>
                                    <p class="mb-1 text-dark">{{ $chat->message }}</p>
                                    <small class="text-muted d-block text-end" style="font-size: 0.7rem;">{{ $chat->created_at->format('H:i') }}</small>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center text-muted h-100 d-flex flex-column justify-content-center align-items-center">
                            <i class='bx bx-chat fs-1 mb-2 text-light'></i>
                            <p>Belum ada percakapan.<br>Silakan kirim pesan jika Anda memiliki pertanyaan.</p>
                        </div>
                    @endforelse
                </div>
                <div class="card-footer bg-white border-top-0 p-3">
                    <form action="{{ route('chat.store', $order) }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <input type="text" name="message" class="form-control rounded-pill px-4" placeholder="Ketik pesan Anda..." required autocomplete="off">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class='bx bxs-send'></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Bayar -->
    @if($order->status != 'Cancelled')
    <div class="modal fade d-print-none" id="payModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('payment.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg">
                @csrf
                <div class="modal-header bg-success text-white border-0">
                    <h5 class="modal-title fw-bold"><i class='bx bx-wallet'></i> Formulir Pembayaran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-4">Silakan transfer sisa tagihan ke rekening BCA 1234567890 a.n Katering Kita. Lalu unggah bukti transfer di bawah ini.</p>
                    
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenis Pembayaran</label>
                        <select name="type" class="form-select" required>
                            <option value="DP">Uang Muka (DP) / Cicilan</option>
                            <option value="Pelunasan">Pelunasan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nominal yang Dibayar (Rp)</label>
                        <input type="number" name="amount" class="form-control" placeholder="Contoh: 500000" min="1000" max="{{ $sisa ?? $order->total_amount }}" required>
                        <div class="form-text">Maksimal: Rp {{ isset($sisa) ? number_format($sisa, 0, ',', '.') : 0 }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Bukti Transfer</label>
                        <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4 fw-bold">Kirim Bukti Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</x-app>
