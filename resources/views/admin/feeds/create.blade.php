@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Poultry', 'Feeds', 'Add Stock']])

        <div class="card">
            <div class="card-header">
                <i class="fas fa-seedling me-1"></i>
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

                <form action="/feeds/store" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Feed Name</label>
                            <input type="text" name="feed_name" class="form-control" value="{{ old('feed_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Feed Type</label>
                            <input type="text" name="feed_type" class="form-control" value="{{ old('feed_type') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Supplier</label>
                            <input type="text" name="supplier" class="form-control" value="{{ old('supplier') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Quantity (kg)</label>
                            <input type="number" step="0.1" name="quantity_in_kg" class="form-control" value="{{ old('quantity_in_kg', 0) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Unit Price</label>
                            <input type="number" step="0.01" name="unit_price" class="form-control" value="{{ old('unit_price', 0) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Purchase Date</label>
                            <input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Save Feed Stock
                            </button>
                            <a href="/feeds" class="btn btn-link">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

