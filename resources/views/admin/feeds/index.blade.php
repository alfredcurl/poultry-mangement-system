@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Poultry', 'Feeds']])

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mt-4 h3">{{ $title }}</h1>
            <a href="/feeds/create" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Add Feed Stock
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Supplier</th>
                            <th>Purchased</th>
                            <th class="text-end">Quantity (kg)</th>
                            <th class="text-end">Remaining (kg)</th>
                            <th class="text-end">Total Cost</th>
                            <th>Expiry</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($feeds as $feed)
                            <tr>
                                <td>{{ $feed->feed_name }}</td>
                                <td>{{ $feed->feed_type }}</td>
                                <td>{{ $feed->supplier ?? '-' }}</td>
                                <td>{{ $feed->purchase_date->format('d M Y') }}</td>
                                <td class="text-end">{{ number_format($feed->quantity_in_kg, 2) }}</td>
                                <td class="text-end {{ $feed->remaining < 50 ? 'text-danger fw-bold' : '' }}">
                                    {{ number_format($feed->remaining, 2) }}
                                </td>
                                <td class="text-end">UGX {{ number_format($feed->total_cost, 0) }}</td>
                                <td>{{ optional($feed->expiry_date)->format('d M Y') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No feed stock yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

