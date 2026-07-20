<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold m-0"><i class='bx bx-message-square-detail text-primary'></i> Moderasi Ulasan Pelanggan</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="data-table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" width="15%">Pengirim</th>
                        <th scope="col" width="10%">Rating</th>
                        <th scope="col" width="45%">Ulasan / Review</th>
                        <th scope="col" width="15%">Status Publish</th>
                        @if(Auth::user()->role != 'Customer')
                        <th scope="col" width="15%">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($testimonials as $testi)
                        <tr>
                            <td class="fw-bold">
                                {{ $testi->customer->name ?? 'Unknown' }}<br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($testi->created_at)->format('d M Y') }}</small>
                            </td>
                            <td>
                                <div class="text-warning fs-5">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testi->rating)
                                            <i class='bx bxs-star'></i>
                                        @else
                                            <i class='bx bx-star'></i>
                                        @endif
                                    @endfor
                                </div>
                            </td>
                            <td>
                                <i>"{{ $testi->review }}"</i>
                            </td>
                            <td>
                                @if($testi->is_published)
                                    <span class="badge bg-success"><i class='bx bx-globe'></i> Dipublikasikan</span>
                                @else
                                    <span class="badge bg-secondary"><i class='bx bx-hide'></i> Disembunyikan</span>
                                @endif
                            </td>
                            @if(Auth::user()->role != 'Customer')
                            <td>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('testimonial.status', $testi) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if($testi->is_published)
                                            <button type="submit" class="btn btn-warning btn-sm" title="Tarik dari Publik">
                                                <i class='bx bx-hide'></i>
                                            </button>
                                        @else
                                            <input type="hidden" name="is_published" value="1">
                                            <button type="submit" class="btn btn-success btn-sm" title="Setujui & Publish">
                                                <i class='bx bx-check'></i>
                                            </button>
                                        @endif
                                    </form>

                                    @if(in_array(Auth::user()->role, ['Superadmin', 'Admin']))
                                    <form action="{{ route('testimonial.destroy', $testi) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit" title="Hapus Ulasan"><i class='bx bx-trash'></i></button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
