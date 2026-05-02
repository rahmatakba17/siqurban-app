@extends('layouts.app')

@section('page-title', 'Edit Wilayah')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="card p-6 md:p-8">
        <form method="POST" action="{{ route('admin.regions.update', $region) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="form-label">Nama Wilayah</label>
                <input type="text" id="name" name="name" value="{{ old('name', $region->name) }}" class="form-input" required>
                @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="description" class="form-label">Deskripsi</label>
                <textarea id="description" name="description" rows="4" class="form-input" placeholder="Deskripsi wilayah (opsional)">{{ old('description', $region->description) }}</textarea>
            </div>

            <div>
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-input" required>
                    <option value="active" @selected(old('status', $region->status) === 'active')>Active</option>
                    <option value="inactive" @selected(old('status', $region->status) === 'inactive')>Inactive</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn-primary">Update</button>
                <a href="{{ route('admin.regions.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
