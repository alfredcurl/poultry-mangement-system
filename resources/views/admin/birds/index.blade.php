@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Poultry', 'Birds']])

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mt-4 h3">{{ $title }}</h1>
            <a href="/birds/create" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Add Bird Batch
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-body table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Breed</th>
                            <th>Acquired</th>
                            <th class="text-end">Initial Qty</th>
                            <th class="text-end">Current Qty</th>
                            <th>Status</th>
                            <th>Age (weeks)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($birds as $bird)
                            <tr>
                                <td>{{ $bird->bird_type }}</td>
                                <td>{{ $bird->breed }}</td>
                                <td>{{ $bird->acquisition_date->format('d M Y') }}</td>
                                <td class="text-end">{{ number_format($bird->quantity) }}</td>
                                <td class="text-end">{{ number_format($bird->current_quantity) }}</td>
                                <td>
                                    <span class="badge bg-{{ $bird->status === 'active' ? 'success' : ($bird->status === 'sold' ? 'secondary' : 'danger') }}">
                                        {{ ucfirst($bird->status) }}
                                    </span>
                                </td>
                                <td>{{ $bird->age_in_weeks }}</td>
                                <td>
                                    <a href="/birds/edit/{{ $bird->id }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No bird batches yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

