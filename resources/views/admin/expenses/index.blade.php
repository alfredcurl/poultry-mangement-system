@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Finance', 'Expenses']])

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mt-4 h3">{{ $title }}</h1>
            <a href="/expenses/create" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Add Expense
            </a>
        </div>

        <form class="row g-3 mb-3" method="GET" action="/expenses">
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
                <a href="/expenses" class="btn btn-link">Reset</a>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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
                            <th>Date</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Paid To</th>
                            <th>Receipt #</th>
                            <th class="text-end">Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($expenses as $expense)
                            <tr>
                                <td>{{ $expense->expense_date->format('d M Y') }}</td>
                                <td>{{ $expense->expense_type }}</td>
                                <td>{{ $expense->description }}</td>
                                <td>{{ $expense->paid_to ?? '-' }}</td>
                                <td>{{ $expense->receipt_number ?? '-' }}</td>
                                <td class="text-end">UGX {{ number_format($expense->amount, 0) }}</td>
                                <td>
                                    <a href="/expenses/edit/{{ $expense->id }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/expenses/delete/{{ $expense->id }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this expense?');">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No expenses yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

