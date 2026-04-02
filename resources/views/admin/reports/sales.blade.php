@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Reports', 'Sales']])

        <div class="card mb-3">
            <div class="card-body">
                <form class="row g-3 align-items-end" method="GET" action="/reports/sales">
                    <div class="col-md-3">
                        <label class="form-label">Period</label>
                        <select name="period" class="form-select">
                            <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ $period === 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Reference</label>
                        <input type="{{ $period === 'yearly' ? 'number' : ($period === 'daily' ? 'date' : 'month') }}"
                               name="date" class="form-control" value="{{ $date }}">
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
                        <p class="text-muted mb-1">Total Sales</p>
                        <div class="display-6 text-success">UGX {{ number_format($totalSales, 0) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                @if ($period === 'yearly')
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                                <tr>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $sale->month)->format('F') }}</td>
                                    <td class="text-end">{{ number_format($sale->total_quantity) }}</td>
                                    <td class="text-end">UGX {{ number_format($sale->total_sales, 0) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No sales data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Orders</th>
                                <th class="text-end">Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                                <tr>
                                    <td>{{ $sale['product']->product_name ?? 'Unknown' }}</td>
                                    <td class="text-end">{{ number_format($sale['quantity'] ?? 0) }}</td>
                                    <td class="text-end">{{ number_format($sale['orders'] ?? ($sale['order_count'] ?? 0)) }}</td>
                                    <td class="text-end">UGX {{ number_format($sale['total'] ?? ($sale['total_sales'] ?? 0), 0) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No sales data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection

