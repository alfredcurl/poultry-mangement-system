@extends('/layouts/auth')

@push('css-dependencies')
<link href="/css/landing.css" rel="stylesheet" />
@endpush

@push('scripts-dependencies')
<script src="/js/landing.js"></script>
@endpush

@section("content")
<header class="masthead">
    <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
        <div class="d-flex justify-content-center">
            <div class="text-center">
                <h1 class="mx-auto my-0 text-uppercase">N &amp; M Poultry Farm</h1>
                <h2 class="text-white-50 mx-auto mt-2 mb-5">
                    Premium eggs from healthy flocks, delivered fresh daily
                </h2>
                <a class="btn btn-warning text-dark fw-semibold" href="auth">
                    <i class="fa-solid fa-egg me-2"></i>Shop Eggs
                </a>
            </div>
        </div>
    </div>
</header>
@endsection