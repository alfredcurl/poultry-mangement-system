@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Poultry', 'Medications']])

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mt-4 h3">{{ $title }}</h1>
            <a href="/medications/create" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Add Medication
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
                            <th class="text-end">Quantity</th>
                            <th class="text-end">Remaining</th>
                            <th class="text-end">Total Cost</th>
                            <th>Expiry</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($medications as $medication)
                            <tr>
                                <td>{{ $medication->medication_name }}</td>
                                <td>{{ $medication->medication_type }}</td>
                                <td>{{ $medication->supplier ?? '-' }}</td>
                                <td>{{ $medication->purchase_date->format('d M Y') }}</td>
                                <td class="text-end">{{ number_format($medication->quantity, 2) }} {{ $medication->unit }}</td>
                                <td class="text-end {{ $medication->remaining < 10 ? 'text-danger fw-bold' : '' }}">
                                    {{ number_format($medication->remaining, 2) }} {{ $medication->unit }}
                                </td>
                                <td class="text-end">UGX {{ number_format($medication->total_cost, 0) }}</td>
                                <td>{{ optional($medication->expiry_date)->format('d M Y') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No medication stock yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

