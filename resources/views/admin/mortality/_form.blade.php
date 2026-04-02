@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Bird Batch</label>
        <select name="bird_id" class="form-select" required>
            <option value="">-- Select Bird Batch --</option>
            @foreach ($birds as $birdOption)
                <option value="{{ $birdOption->id }}" {{ old('bird_id', $record->bird_id ?? '') == $birdOption->id ? 'selected' : '' }}>
                    {{ $birdOption->bird_type }} - {{ $birdOption->breed }} ({{ $birdOption->quantity }} birds)
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Death Date</label>
        <input type="date" name="death_date" class="form-control" value="{{ old('death_date', isset($record) ? $record->death_date->format('Y-m-d') : '') }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Number of Deaths</label>
        <input type="number" name="number_of_deaths" min="1" class="form-control" value="{{ old('number_of_deaths', $record->number_of_deaths ?? 1) }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Cause of Death</label>
        <input type="text" name="cause_of_death" class="form-control" value="{{ old('cause_of_death', $record->cause_of_death ?? '') }}">
    </div>
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $record->notes ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <button class="btn btn-primary">
            <i class="fas fa-save me-1"></i>
            {{ isset($record) ? 'Update Record' : 'Save Record' }}
        </button>
        <a href="/mortality" class="btn btn-link">Cancel</a>
    </div>
</div>

