@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Reports', 'Profit & Loss']])

        <div class="card mb-3">
            <div class="card-body">
                <form class="row g-3 align-items-end" method="GET" action="/reports/profit-loss">
                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary">Apply</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">Income</div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Egg Sales</span>
                            <strong>UGX {{ number_format($eggSales, 0) }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Total Income</span>
                            <strong>UGX {{ number_format($eggSales, 0) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">Expenses</div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Operational Expenses</span>
                            <strong>UGX {{ number_format($generalExpenses, 0) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Feed Purchases</span>
                            <strong>UGX {{ number_format($feedExpenses, 0) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Medication Purchases</span>
                            <strong>UGX {{ number_format($medicationExpenses, 0) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Bird Acquisition</span>
                            <strong>UGX {{ number_format($birdAcquisition, 0) }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Total Expenses</span>
                            <strong>UGX {{ number_format($totalExpenses, 0) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <p class="text-muted mb-1">Net Result</p>
                <div class="display-5 {{ $profit >= 0 ? 'text-success' : 'text-danger' }}">
                    UGX {{ number_format($profit, 0) }}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

