@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Reports', 'Egg Production', 'Daily']])

        <div class="card mb-3">
            <div class="card-body">
                <form class="row g-3 align-items-end" method="GET" action="/egg-production/daily-report">
                    <div class="col-md-4">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ $date }}">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary">Apply</button>
                    </div>
                </form>
            </div>
        </div>

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
                                <td>{{ $production->bird->bird_type }} - {{ $production->bird->breed }}</td>
                                <td class="text-end">{{ number_format($production->eggs_collected) }}</td>
                                <td class="text-end text-danger">{{ number_format($production->damaged_eggs) }}</td>
                                <td class="text-end text-success">{{ number_format($production->good_eggs) }}</td>
                                <td>{{ $production->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No production recorded</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

