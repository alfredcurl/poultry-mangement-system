@php
    $isEdit = isset($bird);
@endphp

@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Bird Type</label>
        <input type="text" name="bird_type" class="form-control" value="{{ old('bird_type', $bird->bird_type ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Breed</label>
        <input type="text" name="breed" class="form-control" value="{{ old('breed', $bird->breed ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Quantity</label>
        <input type="number" name="quantity" class="form-control" min="1" value="{{ old('quantity', $bird->quantity ?? 0) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Acquisition Date</label>
        <input type="date" name="acquisition_date" class="form-control" value="{{ old('acquisition_date', isset($bird) ? $bird->acquisition_date->format('Y-m-d') : '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Acquisition Cost</label>
        <input type="number" step="0.01" name="acquisition_cost" class="form-control" value="{{ old('acquisition_cost', $bird->acquisition_cost ?? 0) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Age (weeks)</label>
        <input type="number" name="age_in_weeks" class="form-control" min="0" value="{{ old('age_in_weeks', $bird->age_in_weeks ?? 0) }}" required>
    </div>
    @if($isEdit)
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                @foreach(['active', 'sold', 'deceased'] as $status)
                    <option value="{{ $status }}" {{ old('status', $bird->status ?? '') === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $bird->notes ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <button class="btn btn-primary">
            <i class="fas fa-save me-1"></i>
            {{ $isEdit ? 'Update Bird Batch' : 'Save Bird Batch' }}
        </button>
        <a href="/birds" class="btn btn-link">Cancel</a>
    </div>
</div>

