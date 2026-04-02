@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Poultry', 'Medications', 'Usage']])

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mt-4 h3">{{ $title }}</h1>
            <a href="/medications/usage/create" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Record Usage
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
                            <th>Date</th>
                            <th>Medication</th>
                            <th>Bird Batch</th>
                            <th class="text-end">Quantity Used</th>
                            <th>Administered By</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usages as $usage)
                            <tr>
                                <td>{{ $usage->administration_date->format('d M Y') }}</td>
                                <td>{{ $usage->medication->medication_name }}</td>
                                <td>{{ $usage->bird->bird_type }} - {{ $usage->bird->breed }}</td>
                                <td class="text-end">
                                    {{ number_format($usage->quantity_used, 2) }} {{ $usage->medication->unit }}
                                </td>
                                <td>{{ $usage->administered_by ?? '-' }}</td>
                                <td>{{ $usage->reason ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No medication usage recorded</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

