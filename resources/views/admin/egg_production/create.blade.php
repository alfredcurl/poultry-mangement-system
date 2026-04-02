@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Poultry', 'Egg Production', 'Record']])

        <div class="card">
            <div class="card-header">
                <i class="fas fa-egg me-1"></i>
                {{ $title }}
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please fix the errors below.</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/egg-production/store" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Bird Batch</label>
                            <select name="bird_id" class="form-select" required>
                                <option value="">-- Select Bird Batch --</option>
                                @foreach ($birds as $bird)
                                    <option value="{{ $bird->id }}" {{ old('bird_id') == $bird->id ? 'selected' : '' }}>
                                        {{ $bird->bird_type }} - {{ $bird->breed }} ({{ $bird->quantity }} birds)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Production Date</label>
                            <input type="date" name="production_date" class="form-control" value="{{ old('production_date', date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Eggs Collected</label>
                            <input type="number" name="eggs_collected" class="form-control" min="0" value="{{ old('eggs_collected', 0) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Damaged Eggs</label>
                            <input type="number" name="damaged_eggs" class="form-control" min="0" value="{{ old('damaged_eggs', 0) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Save Production
                            </button>
                            <a href="/egg-production" class="btn btn-link">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

