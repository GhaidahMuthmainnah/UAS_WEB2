<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card shadow-sm border-0 border-bottom border-success border-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-success">Pendapatan <span>| Total</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success" style="width: 60px; height: 60px; font-size: 32px;">
                            <i class="bx bx-wallet"></i>
                        </div>
                        <div class="ps-3">
                            <h5 class="fw-bold mb-0">Rp {{ number_format($revenue, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expense Card -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card shadow-sm border-0 border-bottom border-danger border-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-danger">Pengeluaran <span>| Total</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger" style="width: 60px; height: 60px; font-size: 32px;">
                            <i class="bx bx-money-withdraw"></i>
                        </div>
                        <div class="ps-3">
                            <h5 class="fw-bold mb-0">Rp {{ number_format($expense, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profit Card -->
        <div class="col-xxl-4 col-md-12">
            <div class="card info-card customers-card shadow-sm border-0 border-bottom border-primary border-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary">Profit Bersih <span>| Estimasi</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary" style="width: 60px; height: 60px; font-size: 32px;">
                            <i class="bx bx-line-chart"></i>
                        </div>
                        <div class="ps-3">
                            <h5 class="fw-bold mb-0">Rp {{ number_format($profit, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- Extra Metrics -->
        <div class="col-md-6 col-lg-3">
            <div class="card bg-warning text-dark shadow-sm border-0 h-100">
                <div class="card-body py-4 text-center">
                    <h1 class="fw-bold display-5 mb-0">{{ $activeOrdersCount }}</h1>
                    <p class="mb-0 fw-semibold">Pesanan Aktif (Belum Lunas)</p>
                    <small class="text-dark opacity-75">Dari Total {{ $totalOrdersCount }} Semua Pesanan</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card bg-info text-white shadow-sm border-0 h-100">
                <div class="card-body py-4 text-center">
                    <h1 class="fw-bold display-5 mb-0">{{ $avgRating }} <i class='bx bxs-star fs-4'></i></h1>
                    <p class="mb-0 fw-semibold">Rating Pelanggan</p>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Grafik Keuangan (6 Bulan)</h5>
                    <div id="financeChart" style="min-height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- Recent Orders -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Pesanan Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Order</th>
                                    <th>Pelanggan</th>
                                    <th>Acara</th>
                                    <th>Tanggal Order</th>
                                    <th>Status</th>
                                    <th>Nilai Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td><span class="text-primary fw-bold">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                                    <td>{{ $order->customer->name ?? 'Unknown' }}</td>
                                    <td>{{ $order->event->event_name ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                                    <td>
                                        @if($order->status == 'Paid')
                                            <span class="badge bg-success">Lunas</span>
                                        @elseif($order->status == 'Pending')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($order->status == 'Confirmed')
                                            <span class="badge bg-info text-dark">Dikonfirmasi</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            new ApexCharts(document.querySelector("#financeChart"), {
                series: [{
                    name: 'Pendapatan',
                    data: {!! $chartRevenue !!}
                }, {
                    name: 'Pengeluaran',
                    data: {!! $chartExpense !!}
                }],
                chart: {
                    height: 250,
                    type: 'area',
                    toolbar: { show: false }
                },
                colors: ['#198754', '#dc3545'],
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.4,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    categories: {!! $chartMonths !!},
                },
                tooltip: {
                    y: {
                        formatter: function(val) { return "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); }
                    }
                }
            }).render();
        });
    </script>
</x-app>
