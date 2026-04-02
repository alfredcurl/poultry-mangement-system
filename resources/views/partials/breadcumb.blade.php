@php
    $breadcrumbItems = $items ?? [ucwords(explode('/', Request::path())[0])];
@endphp

<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item">{{ auth()->user()->role_id == 1 ? 'Admin' : 'Customer' }}</li>
        @foreach ($breadcrumbItems as $item)
            <li class="breadcrumb-item">{{ $item }}</li>
        @endforeach
        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
    </ol>
</nav>

<hr class="mt-0 mb-4">