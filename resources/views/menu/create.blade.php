<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('menu.store') }}" method="post" class="form">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label required">Nama Menu</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" required value="{{ old('name') }}">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label required">Harga (Rp)</label>
                <input class="form-control @error('price') is-invalid @enderror" type="number" id="price" name="price" required min="0" value="{{ old('price', 0) }}">
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" @checked(old('is_available', true))>
                <label class="form-check-label" for="is_available">Tersedia</label>
            </div>

            <div class="text-end">
                <a href="{{ route('menu.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>
