@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Reports', 'Expenses', 'Monthly']])

        <div class="card mb-3">
            <div class="card-body">
                <form class="row g-3 align-items-end" method="GET" action="/expenses/monthly-report">
                    <div class="col-md-4">
                        <label class="form-label">Month</label>
                        <input type="month" name="month" class="form-control" value="{{ $month }}">
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
                        <p class="text-muted mb-1">Total Expenses</p>
                        <div class="display-6 text-danger">UGX {{ number_format($totalExpenses, 0) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Expense Type</th>
                            <th class="text-end">Transactions</th>
                            <th class="text-end">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($expenses as $expense)
                            <tr>
                                <td>{{ $expense->expense_type }}</td>
                                <td class="text-end">{{ number_format($expense->count) }}</td>
                                <td class="text-end">UGX {{ number_format($expense->total_amount, 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No expenses for the selected month</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

