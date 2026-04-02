@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Poultry', 'Birds', 'Create']])

        <div class="card">
            <div class="card-header">
                <i class="fas fa-dove me-1"></i>
                {{ $title }}
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please fix the errors below.</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/birds/store" method="POST">
                    @include('admin.birds._form')
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

