@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Poultry', 'Medications', 'Record Usage']])

        <div class="card">
            <div class="card-header">
                <i class="fas fa-syringe me-1"></i>
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

                <form action="/medications/usage/store" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Medication</label>
                            <select name="medication_id" class="form-select" required>
                                <option value="">-- Select Medication --</option>
                                @foreach ($medications as $medication)
                                    <option value="{{ $medication->id }}" {{ old('medication_id') == $medication->id ? 'selected' : '' }}>
                                        {{ $medication->medication_name }} ({{ number_format($medication->getRemainingQuantity(), 2) }} {{ $medication->unit }} left)
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
                            <label class="form-label">Administration Date</label>
                            <input type="date" name="administration_date" class="form-control" value="{{ old('administration_date', date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Quantity Used</label>
                            <input type="number" step="0.1" name="quantity_used" class="form-control" min="0" value="{{ old('quantity_used', 0) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Administered By</label>
                            <input type="text" name="administered_by" class="form-control" value="{{ old('administered_by') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Reason</label>
                            <input type="text" name="reason" class="form-control" value="{{ old('reason') }}">
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
                            <a href="/medications/usage" class="btn btn-link">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

