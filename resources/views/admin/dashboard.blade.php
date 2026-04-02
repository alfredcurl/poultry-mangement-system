@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Dashboard']])

        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="h5 mb-0">Today's Good Eggs</div>
                        <div class="display-6 fw-bold">{{ number_format($todayEggs) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="h5 mb-0">Sales (This Month)</div>
                        <div class="display-6 fw-bold">UGX {{ number_format($monthSales, 0) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-info text-white h-100">
                    <div class="card-body">
                        <div class="h5 mb-0">Active Birds</div>
                        <div class="display-6 fw-bold">{{ number_format($totalBirds) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-danger text-white h-100">
                    <div class="card-body">
                        <div class="h5 mb-0">Mortality (This Month)</div>
                        <div class="display-6 fw-bold">{{ number_format($monthMortality) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-seedling me-1"></i>
                        Low Feed Stock (&lt; 50kg)
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Feed</th>
                                        <th>Type</th>
                                        <th class="text-end">Remaining (kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lowStockFeeds as $feed)
                                        <tr>
                                            <td>{{ $feed->feed_name }}</td>
                                            <td>{{ $feed->feed_type }}</td>
                                            <td class="text-end">{{ number_format($feed->getRemainingQuantity(), 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-3">All good here 👌</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-pills me-1"></i>
                        Low Medication Stock (&lt; 10 units)
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Medication</th>
                                        <th>Type</th>
                                        <th class="text-end">Remaining</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lowStockMeds as $med)
                                        <tr>
                                            <td>{{ $med->medication_name }}</td>
                                            <td>{{ $med->medication_type }}</td>
                                            <td class="text-end">{{ number_format($med->getRemainingQuantity(), 2) }} {{ $med->unit }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-3">Healthy inventory 🙌</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

