@extends('/layouts/main')

@push('css-dependencies')
<link rel="stylesheet" type="text/css" href="/css/product.css" />
@endpush

@push('scripts-dependencies')
<script src="/js/product.js" type="module"></script>
@endpush

@push('modals-dependencies')
@include('/partials/product/product_detail_modal')
@endpush

@section('content')
<!-- product -->
<section id="product" class="pb-5">
    <div class="container">

        @if(session()->has('message'))
        {!! session("message") !!}
        @endif

        <h5 class="section-title h1">Farm Fresh Eggs</h5>
        @can('add_product',App\Models\Product::class)
        <div class="d-flex align-items-end flex-column mb-4">
            <a style="text-decoration: none;" href="/product/add_product" class="btn btn-warning text-dark fw-semibold">
                <i class="fa-solid fa-egg me-2"></i>Add egg product
            </a>
        </div>
        @else
        <div class="mb-5"></div>
        @endcan

        <div class="row justify-content-center">
            @forelse($product as $row)
            <!-- Product card -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="{{ asset('storage/' . $row->image) }}"
                                          alt="Product Name"></p>
                                    <h4 class="card-title">{{ $row->product_name }}</h4>
                                    <p class="card-text text-muted mb-1">
                                        <i class="fa-solid fa-egg text-warning me-1"></i>
                                        {{ ucfirst(str_replace('_',' ', $row->egg_size)) }} • {{ $row->quantity_per_unit }} eggs
                                    </p>
                                    <p class="card-text fw-bold text-success mb-2">
                                        UGX {{ number_format($row->price, 0) }}
                                        @if($row->discount > 0)
                                            <span class="badge bg-danger ms-1">{{ $row->discount }}% off</span>
                                        @endif
                                    </p>
                                    <span class="badge bg-light text-dark">
                                        <i class="fa-solid fa-warehouse me-1"></i>{{ number_format($row->stock) }} units in stock
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="backside">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="card-title">{{ $row->product_name }}</h4>
                                    <p class="card-text">{{ \Illuminate\Support\Str::limit($row->description, 140) }}</p>

                                    <!-- detail -->
                                    <button data-id="{{ $row->id }}"
                                      class="btn btn-primary btn-sm detail">Detail</button>

                                    <!-- ulasan -->
                                    <a href="/review/product/{{ $row->id }}"><button
                                          class="btn btn-primary btn-sm ubah">Review</button></a>

                                    <!-- [admin] ubah -->
                                    @can('edit_product',App\Models\Product::class)
                                    <a href="/product/edit_product/{{ $row->id }}"><button
                                          class="btn btn-primary btn-sm ubah">Edit</button></a>
                                    @endcan
                                    @can('create_order',App\Models\Order::class)
                                    <a href="/order/make_order/{{ $row->id }}"><button
                                          class="btn btn-primary btn-sm ubah">Buy</button></a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./product card -->
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted mb-0">No egg products yet. Please add one.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- product -->

@endsection