@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Poultry', 'Egg Production']])

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mt-4 h3">{{ $title }}</h1>
            <a href="/egg-production/create" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Record Production
            </a>
        </div>

        <form class="row g-3 mb-3" method="GET" action="/egg-production">
            <div class="col-md-4">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4 align-self-end">
                <button class="btn btn-outline-secondary me-2">Filter</button>
                <a href="/egg-production" class="btn btn-link">Reset</a>
            </div>
        </form>

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <p class="text-muted mb-1">Collected Eggs</p>
                        <div class="display-6">{{ number_format($totalEggs) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <p class="text-muted mb-1">Damaged Eggs</p>
                        <div class="display-6 text-danger">{{ number_format($totalDamaged) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <p class="text-muted mb-1">Good Eggs</p>
                        <div class="display-6 text-success">{{ number_format($totalGood) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Bird Batch</th>
                            <th class="text-end">Collected</th>
                            <th class="text-end">Damaged</th>
                            <th class="text-end">Good</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productions as $production)
                            <tr>
                                <td>{{ $production->production_date->format('d M Y') }}</td>
                                <td>{{ $production->bird->bird_type }} - {{ $production->bird->breed }}</td>
                                <td class="text-end">{{ number_format($production->eggs_collected) }}</td>
                                <td class="text-end text-danger">{{ number_format($production->damaged_eggs) }}</td>
                                <td class="text-end text-success">{{ number_format($production->good_eggs) }}</td>
                                <td>{{ $production->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No egg production records yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

