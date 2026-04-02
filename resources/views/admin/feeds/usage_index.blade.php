@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Poultry', 'Feeds', 'Usage']])

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mt-4 h3">{{ $title }}</h1>
            <a href="/feeds/usage/create" class="btn btn-primary">
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
                            <th>Feed</th>
                            <th>Bird Batch</th>
                            <th class="text-end">Quantity Used (kg)</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usages as $usage)
                            <tr>
                                <td>{{ $usage->usage_date->format('d M Y') }}</td>
                                <td>{{ $usage->feed->feed_name }}</td>
                                <td>{{ $usage->bird->bird_type }} - {{ $usage->bird->breed }}</td>
                                <td class="text-end">{{ number_format($usage->quantity_used_kg, 2) }}</td>
                                <td>{{ $usage->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No feed usage recorded</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

