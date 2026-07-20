<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Waktu Pengiriman</th>
                        <th scope="col">Acara & Lokasi</th>
                        <th scope="col">Kurir</th>
                        <th scope="col">Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deliveries as $delivery)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle fw-bold">
                                {{ \Carbon\Carbon::parse($delivery->delivery_time)->format('d M Y') }}<br>
                                <span class="text-primary">{{ \Carbon\Carbon::parse($delivery->delivery_time)->format('H:i') }} WIB</span>
                            </td>
                            <td class="align-middle">
                                <strong>{{ $delivery->order->event->event_name ?? 'N/A' }}</strong><br>
                                <small class="text-muted"><i class='bx bx-map'></i> {{ $delivery->order->event->location ?? '-' }}</small><br>
                                <small class="text-muted"><i class='bx bx-user'></i> Klien: {{ $delivery->order->customer->name ?? '-' }}</small>
                            </td>
                            <td class="align-middle">{{ $delivery->driver_name ?? '-' }}</td>
                            <td class="align-middle">
                                <form action="{{ route('delivery.status', $delivery) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group input-group-sm">
                                        <select name="status" class="form-select @if($delivery->status == 'Delivered') border-success bg-success text-white @elseif($delivery->status == 'EnRoute') border-warning bg-warning text-dark @endif" onchange="this.form.submit()">
                                            <option value="Scheduled" @selected($delivery->status == 'Scheduled')>Scheduled</option>
                                            <option value="EnRoute" @selected($delivery->status == 'EnRoute')>EnRoute (Di Jalan)</option>
                                            <option value="Delivered" @selected($delivery->status == 'Delivered')>Delivered (Sampai)</option>
                                        </select>
                                    </div>
                                    <noscript><button type="submit" class="btn btn-sm btn-primary mt-1">Ubah</button></noscript>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
