@extends('/layouts/main')

@push('css-dependencies')
<link rel="stylesheet" type="text/css" href="/css/order.css" />
@endpush

@push('scripts-dependencies')
<script src="/js/make_order.js"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endpush

@section('content')
<div class="container-fluid px-2 px-lg-4">
  <h1 class="main-title">
    {{ $title }}
  </h1>
  <div class="row">

    <!-- Left -->
    <div class="col-12 col-lg-9">
      <div class="accordion" id="accordionMain">

        <!-- top field -->
        <div class="accordion-item mb-3 px-4 py-3">
          <form action="/order/make_order/{{ $product->id }}" method="post">
            @csrf

            <!-- hidden input -->
            <input type="hidden" name="product_id" value="{{ old('product_id', $product->id) }}">

            <div class="row mb-3">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="product_name">Product Name</label>
                  <input id="product_name" name="product_name" value="{{ $product->product_name }}" type="text"
                    class="form-control" disabled>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="price">Price per pieces</label>
                  @if ($product->discount == 0)
                  <input type="hidden" id="price" name="price" data-truePrice="{{ old('price', $product->price) }}"
                    value="UGX {{ old('price', $product->price) }}" type="text" class="form-control" disabled>
                  @else
                  <input type="hidden" id="price" name="price"
                    data-truePrice="{{ old('price', ((100 - $product->discount)/100) * $product->price) }}"
                    value="UGX {{ old('price', ((100 - $product->discount)/100) *$product->price) }}" type="text"
                    class="form-control" disabled>
                  @endif
                  <div class="input-group" style="display:unset;">
                    <div class="input-group-prepend">
                      @if ($product->discount == 0)
                      <span class="input-group-text">
                        {{ $product->price }}
                      </span>
                      @else
                      <span class="input-group-text">UGX {{ ((100 - $product->discount)/100) * $product->price }} <span
                          class="strikethrough ms-4">
                          {{ $product->price }}
                        </span><sup><sub class="mx-1">of</sub>
                          {{ $product->discount }}%
                        </sup>
                      </span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group col-2">
              <label for="quantity">Quantity</label>
              <input id="quantity" name="quantity" data-productId="{{ $product->id }}"
                value="{{ old('quantity', '0' ) }}" type="number" min="0"
                class="form-control @error('quantity') is-invalid @enderror" onchange="myCounter()">
            </div>
            <div class="mb-3 col-12">
              @error('quantity')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group mb-3">
              <label for="address">Delivery Address</label>
              <input id="address" name="address" type="text" class="form-control @error('address') is-invalid @enderror"
                value="{{ old('address', auth()->user()->address) }}">
              @error('address')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>
        </div>

        {{-- COD --}}
        <div class="accordion-item mb-3 border">
          <div class="px-4 py-3 d-flex justify-content-between align-items-center">
            <div class="w-100">
              <h2 class="h5 mb-1">Cash on Delivery</h2>
              <p class="text-muted mb-0">We currently only accept cash on delivery payments.</p>
              <input type="hidden" name="payment_method" value="{{ $codPaymentId }}">
              @error('payment_method')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>
            <span class="ms-3">
              <img src="{{ asset('storage/icons/cash-on-delivery.png') }}" height="50px" alt="logo COD" />
            </span>
          </div>
        </div>
      </div>
    </div>
    <!-- Right -->
    <div class="col-12 col-lg-3">
      <div class="card position-sticky top-0">
        <div class="p-3 bg-light bg-opacity-10">
          <h6 class="card-title mb-3">Order Summary</h6>
          {{-- loading --}}
          <div id="loading_transaction" style="display: none">
            <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_raiw2hpe.json" background="transparent"
              speed="1" style="width: auto; height: 125px;" loop autoplay>
            </lottie-player>
          </div>
          {{-- transaction resume --}}
          <div id="transaction">
            <div class="d-flex justify-content-between mb-1 small">
              <span>Subtotal</span> <span><span>UGX </span> <span id="sub-total">0</span></span>
            </div>
            <div class="d-flex justify-content-between mb-1 small">
              <span>Delivery</span><span>
                <span>UGX </span><span id="shipping" data-shippingCost="0">0</span>
              </span>
            </div>

            <input type="hidden" name="coupon_used" id="coupon_used" value="0">

            <div class="d-flex justify-content-between mb-1 small">
              <span>Coupon
                @if (auth()->user()->coupon == 0)
                (no coupon)
                @else
                <span class="align-items-center">
                  <label for="use_coupon" style="cursor:pointer">(use coupon</label>
                </span>
                <span>
                  <input id="use_coupon" type="checkbox" onchange="changeStatesCoupon()">
                </span>
                )
                @endif
              </span><span><span></span><span id="coupon" data-valueCoupon="{{ auth()->user()->coupon }}">
                  {{ auth()->user()->coupon }} Coupon
                </span></span>
            </div>
            @if (auth()->user()->coupon != 0)
            <div class="d-flex justify-content-between mb-1 small text-danger">
              <span>Coupon used</span> <span><span id="couponUsedShow">0 coupon</span></span>
            </div>
            @endif
          </div>
          <hr>
          <div class="d-flex justify-content-between mb-4 small">
            <span>TOTAL</span> <strong class="text-dark"><span>UGX </span><span id="total">0</span></strong>
            <input type="hidden" name="total_price" id="total_price" value="{{ old('total_price', '0') }}">
          </div>
          <div class="form-group small mb-3">
            Make sure you really understand the order you make. If you want to get more information please contact <a
              class="link-danger"
              href="https://wa.me/256000000000?text=I%20want%20to%20ask%20for%20more%20information%20about%20your%20products"
              target="_blank" style="text-decoration: none;">@admin</a>
          </div>
          <button type="submit" class="btn btn-primary w-100 mt-2">Submit</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection