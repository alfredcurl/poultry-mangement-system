@extends('/layouts/main')

@push('css-dependencies')
<link rel="stylesheet" type="text/css" href="/css/order.css" />
@endpush

@push('scripts-dependencies')
<script src="/js/edit_order.js"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

  @include('/partials/breadcumb')

  <!-- flasher -->
  @if(session()->has('message'))
  {!! session("message") !!}
  @endif


  <!-- main content -->
  <div class="row flex-lg-nowrap">

    <div class="col-12 col-lg-9 mb-3">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <div class="e-profile">
                <div class="row">
                  <div class="col-12 col-sm-auto mb-3">
                    <img class="img-account-profile mb-2" src="{{ asset('storage/' . $order->product->image)}}"
                      width="200" alt="{{ $order->product->product_name }}">
                  </div>
                  <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                    <div class="text-sm-left mb-2 mb-sm-0">
                      <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">
                        {{ $order->product->product_name }}
                      </h4>
                      <div class="text-muted">last order modified on
                        {{ $order->updated_at }}
                      </div>
                      <div class="text-muted">
                        <small>Order by </small>
                        <small style="transition:1s;cursor:pointer;" onMouseOver="this.style.fontSize='18px'"
                          onMouseOut="this.style.fontSize='14px'">@
                          {{ $order->user->username }}
                        </small>
                      </div>
                      <div class="mt-2">

                        <!-- Form -->
                        <form action="/order/edit_order/{{ $order->id }}" enctype="multipart/form-data" method="post"
                          id="form_edit_order">
                          @csrf
                      </div>
                    </div>
                    <div class="text-center text-sm-right">
                      <span
                        style="background: #108d6f; color:white; padding:0.08em 0.4em;border-radius: 0.5em;cursor:pointer">
                        Customer
                      </span>
                      <div class="text-muted"><small>Order made at
                          {{ $order->created_at }}
                        </small></div>
                    </div>
                  </div>
                </div>
                <ul class="nav nav-tabs">
                  <li class="nav-item"><a href="" class="active nav-link">Form of {{ $title }}</a></li>
                </ul>
                <div class="tab-content pt-3">
                  <div class="tab-pane active">
                    <div class="row">
                      <div class="col">
                        <div class="row mb-3">
                          <div class="col-12 col-md-6">
                            <div class="form-group">
                              <label for="product_name">Product Name</label>
                              <input class="form-control" type="text" id="product_name" name="product_name"
                                value="{{ old('product_name', $order->product->product_name) }}" disabled>
                            </div>
                          </div>
                          <div class="col-12 col-md-3">
                            <div class="form-group">
                              <label for="product_price">Price per pieces</label>
                              @if ($order->product->discount == 0)
                              <input type="hidden" id="product_price" name="product_price"
                                data-truePrice="{{ old('price', $order->product->price) }}" value="UGX {{ old('price', $order->product->price) }}" type="text" class="form-control" disabled>
                              @else
                              <input type="hidden" id="product_price" name="product_price"
                                data-truePrice="{{ old('product_price', ((100 - $order->product->discount)/100) * $order->product->price) }}"
                                value="UGX {{ old('product_price', ((100 - $order->product->discount)/100) *$order->product->price) }}"
                                type="text" class="form-control" disabled>
                              @endif
                              <div class="input-group" style="display:unset;">
                                <div class="input-group-prepend">
                                  @if ($order->product->discount == 0)
                                  <span class="input-group-text">
                                    {{ $order->product->price }}
                                  </span>
                                  @else
                                  <span class="input-group-text">UGX {{ ((100 - $order->product->discount)/100) *
                                    $order->product->price }} <span class="strikethrough ms-4">
                                      {{ $order->product->price }}
                                    </span><sup><sub class="mx-1">of</sub>
                                      {{ $order->product->discount }}%
                                    </sup>
                                  </span>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-md-3">
                            <div class="form-group">
                              <label for="quantity">Quantity</label>
                              <input class="form-control @error('quantity') is-invalid @enderror" type="number" min="0"
                                id="quantity" name="quantity" data-productId="{{ $order->product_id }}"
                                placeholder="Enter quantity" value="{{ old('quantity', $order->quantity) }}"
                                onchange="myCounter()">
                              @error('address')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col">
                            <div class="form-group">
                              <label class="col control-label">Payment Method</label>
                              <div class="form-control d-flex justify-content-between align-items-center"
                                style="background-color: #e9ecef;">
                                {{ $order->payment->payment_method }} <em class="link-danger">Sorry, can't make
                                  changes to the payment method, right now</em>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-12">
                            <div class="form-group">
                              <label for="address">Delivery Address</label>
                              <input class="form-control @error('address') is-invalid @enderror" id="address"
                                name="address" type="text" placeholder="Enter your address"
                                value="{{ old('address', $order->address) }}">
                              @error('address')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col d-flex justify-content-end">
                        <a class="btn btn-outline-secondary mx-3" href="/order/order_data">Back to Order List</a>
                        <button class="btn btn-dark" type="submit" id="button_edit_order">Save Changes</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- order summmary -->
    <div class="col-12 col-lg-3">
      <div class="card">
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
              <span>Delivery</span> <span><span>UGX </span><span id="shipping"
                  data-shippingCost="0">0</span></span>
            </div>

            <input type="hidden" name="coupon_used" id="coupon_used" value="0">

            <div class="d-flex justify-content-between mb-1 small">
              <span>Coupon
                @if (auth()->user()->coupon == 0)
                (no coupon)
                @else
                <span class="align-items-center">
                  <label for="use_coupon">Use</label>
                </span>
                <span>
                  <input id="use_coupon" type="checkbox" onchange="changeKuponStatus()">
                </span>
                @endif
              </span><span><span></span><span id="coupon" data-valueCoupon="{{ auth()->user()->coupon }}">
                  {{ auth()->user()->coupon }} Coupon
                </span></span>
            </div>
            @if (auth()->user()->coupon != 0)
            <div class="d-flex justify-content-between mb-1 small text-danger">
              <span>Coupon used</span> <span><span id="couponUsedShow" data-couponUsed={{ $order->coupon_used }}>
                  {{ $order->coupon_used }} coupon
                </span></span>
            </div>
            @endif
          </div>
          <hr>
          <div class="d-flex justify-content-between mb-4 small">
            <span>TOTAL</span> <strong class="text-dark"><span>UGX </span><span id="total">
                {{ $order->total_price }}
              </span></strong>
            <input type="hidden" name="total_price" id="total_price" value="{{$order->total_price}}">
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection