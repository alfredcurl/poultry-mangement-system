@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Poultry', 'Mortality']])

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mt-4 h3">{{ $title }}</h1>
            <a href="/mortality/create" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Record Mortality
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Bird Batch</th>
                            <th class="text-end">Deaths</th>
                            <th>Cause</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr>
                                <td>{{ $record->death_date->format('d M Y') }}</td>
                                <td>{{ $record->bird->bird_type }} - {{ $record->bird->breed }}</td>
                                <td class="text-end">{{ number_format($record->number_of_deaths) }}</td>
                                <td>{{ $record->cause_of_death ?? '-' }}</td>
                                <td>{{ $record->notes ?? '-' }}</td>
                                <td>
                                    <a href="/mortality/edit/{{ $record->id }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/mortality/delete/{{ $record->id }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this record?');">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No mortality records yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

