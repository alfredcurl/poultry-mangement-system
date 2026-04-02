@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Reports', 'Egg Production', 'Yearly']])

        <div class="card mb-3">
            <div class="card-body">
                <form class="row g-3 align-items-end" method="GET" action="/egg-production/yearly-report">
                    <div class="col-md-4">
                        <label class="form-label">Year</label>
                        <input type="number" name="year" class="form-control" value="{{ $year }}" min="2000">
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
                            <th>Month</th>
                            <th class="text-end">Collected</th>
                            <th class="text-end">Damaged</th>
                            <th class="text-end">Good</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productions as $production)
                            <tr>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $production->month)->format('F Y') }}</td>
                                <td class="text-end">{{ number_format($production->total_eggs) }}</td>
                                <td class="text-end text-danger">{{ number_format($production->total_damaged) }}</td>
                                <td class="text-end text-success">{{ number_format($production->total_good) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No production recorded</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

