<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold m-0"><i class='bx bx-history text-primary'></i> Riwayat Pesanan Saya</h5>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-primary shadow-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#ulasanModal">
                    <i class='bx bx-star'></i> Tulis Ulasan
                </button>
                <button type="button" class="btn btn-primary shadow-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#pesanModal">
                    <i class='bx bx-plus-circle'></i> Buat Pesanan Baru
                </button>
            </div>
        </div>
        
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
    <!-- Modal Ulasan -->
    <div class="modal fade" id="ulasanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('testimonial.store') }}" method="POST" class="modal-content border-0 shadow-lg">
                @csrf
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold"><i class='bx bx-star'></i> Beri Ulasan Katering</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-4">Bagaimana pengalaman acara Anda bersama kami? Berikan penilaian agar kami bisa terus melayani lebih baik.</p>
                    
                    <div class="mb-4 text-center">
                        <label class="form-label fw-bold d-block">Rating Bintang</label>
                        <div class="rating-stars fs-2 text-warning" style="direction: rtl; display: inline-block;">
                            <!-- Simple radio button implementation for stars -->
                            <input type="radio" id="star5" name="rating" value="5" class="d-none" required />
                            <label for="star5" title="5 stars" class="cursor-pointer px-1"><i class='bx bxs-star'></i></label>
                            
                            <input type="radio" id="star4" name="rating" value="4" class="d-none" />
                            <label for="star4" title="4 stars" class="cursor-pointer px-1"><i class='bx bxs-star'></i></label>
                            
                            <input type="radio" id="star3" name="rating" value="3" class="d-none" />
                            <label for="star3" title="3 stars" class="cursor-pointer px-1"><i class='bx bxs-star'></i></label>
                            
                            <input type="radio" id="star2" name="rating" value="2" class="d-none" />
                            <label for="star2" title="2 stars" class="cursor-pointer px-1"><i class='bx bxs-star'></i></label>
                            
                            <input type="radio" id="star1" name="rating" value="1" class="d-none" />
                            <label for="star1" title="1 star" class="cursor-pointer px-1"><i class='bx bxs-star'></i></label>
                        </div>
                        <style>
                            .rating-stars label { cursor: pointer; color: #ddd; }
                            .rating-stars input:checked ~ label,
                            .rating-stars input:checked ~ label ~ label { color: #ffc107; }
                        </style>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ceritakan Pengalaman Anda</label>
                        <textarea name="review" class="form-control" rows="4" placeholder="Masakannya sangat lezat dan pelayanannya on-time..." required minlength="10"></textarea>
                        <div class="form-text">Tulis minimal 10 karakter ya.</div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Nanti Saja</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <!-- Modal Buat Pesanan Baru -->
    <div class="modal fade" id="pesanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form action="{{ route('myorder.store') }}" method="POST" class="modal-content border-0 shadow-lg">
                @csrf
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold"><i class='bx bx-shopping-bag'></i> Formulir Pemesanan Katering</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama Acara</label>
                            <input type="text" name="event_name" class="form-control" placeholder="Contoh: Resepsi Pernikahan Budi" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Acara</label>
                            <input type="date" name="event_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Estimasi Jumlah Tamu / Porsi</label>
                            <input type="number" name="num_guests" class="form-control" min="10" placeholder="Minimal 10" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tipe Pilihan</label>
                            <select name="product_type" id="product_type" class="form-select" required>
                                <option value="menu">Pilih Menu Satuan</option>
                                <option value="package">Pilih Paket Katering</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lokasi Pengiriman / Acara</label>
                        <textarea name="location" class="form-control" rows="2" placeholder="Alamat lengkap gedung atau rumah..." required></textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Hidangan yang Dipilih</label>
                            <!-- Dropdown Menu -->
                            <select name="product_id" id="product_id_menu" class="form-select">
                                @foreach($menus as $menu)
                                    <option value="{{ $menu->id }}">{{ $menu->name }} - Rp {{ number_format($menu->price, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                            <!-- Dropdown Package (Hidden by default) -->
                            <select name="product_id_package" id="product_id_package" class="form-select d-none" disabled>
                                @foreach($packages as $pkg)
                                    <option value="{{ $pkg->id }}">{{ $pkg->name }} - Rp {{ number_format($pkg->total_price, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Jumlah Beli (Qty)</label>
                            <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">Kirim Pesanan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script to toggle dropdown Menu vs Package -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('product_type');
            const menuSelect = document.getElementById('product_id_menu');
            const pkgSelect = document.getElementById('product_id_package');

            typeSelect.addEventListener('change', function() {
                if(this.value === 'menu') {
                    menuSelect.name = 'product_id';
                    menuSelect.classList.remove('d-none');
                    menuSelect.disabled = false;
                    
                    pkgSelect.name = 'product_id_package';
                    pkgSelect.classList.add('d-none');
                    pkgSelect.disabled = true;
                } else {
                    pkgSelect.name = 'product_id';
                    pkgSelect.classList.remove('d-none');
                    pkgSelect.disabled = false;
                    
                    menuSelect.name = 'product_id_menu';
                    menuSelect.classList.add('d-none');
                    menuSelect.disabled = true;
                }
            });
        });
    </script>
</x-app>
