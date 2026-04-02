@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Poultry', 'Feeds', 'Record Usage']])

        <div class="card">
            <div class="card-header">
                <i class="fas fa-drumstick-bite me-1"></i>
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

                <form action="/feeds/usage/store" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Feed</label>
                            <select name="feed_id" class="form-select" required>
                                <option value="">-- Select Feed --</option>
                                @foreach ($feeds as $feed)
                                    <option value="{{ $feed->id }}" {{ old('feed_id') == $feed->id ? 'selected' : '' }}>
                                        {{ $feed->feed_name }} ({{ number_format($feed->getRemainingQuantity(), 2) }} kg left)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bird Batch</label>
                            <select name="bird_id" class="form-select" required>
                                <option value="">-- Select Bird Batch --</option>
                                @foreach ($birds as $bird)
                                    <option value="{{ $bird->id }}" {{ old('bird_id') == $bird->id ? 'selected' : '' }}>
                                        {{ $bird->bird_type }} - {{ $bird->breed }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Usage Date</label>
                            <input type="date" name="usage_date" class="form-control" value="{{ old('usage_date', date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Quantity Used (kg)</label>
                            <input type="number" step="0.1" name="quantity_used_kg" class="form-control" min="0" value="{{ old('quantity_used_kg', 0) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Save Usage
                            </button>
                            <a href="/feeds/usage" class="btn btn-link">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

