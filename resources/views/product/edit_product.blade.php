@extends('/layouts/main')

@push('css-dependencies')
<link rel="stylesheet" type="text/css" href="/css/product.css" />
@endpush

@push('scripts-dependencies')
<script src="/js/product.js" type="module"></script>
@endpush

@section('content')
<div class="container-fluid p-4" style="background: #eee;">

  @include('/partials/breadcumb')

  @if(session()->has('message'))
  {!! session("message") !!}
  @endif

  <div class="row flex-lg-nowrap">

    <div class="col">
      <div class="row">
        <div class="col mb-3">
          <div class="card">
            <div class="card-body">
              <div class="e-profile">
                <div class="row">
                  <div class="col-12 col-sm-auto mb-3">
                    <img class="mb-2" id="image-preview" src="{{ asset('storage/' . $product->image) }}" width="200"
                      alt="{{ $product->product_name }}">
                  </div>
                  <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                    <div class="text-sm-left mb-2 mb-sm-0">
                      <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">
                        {{ $product->product_name }}
                      </h4>
                      <div class="text-muted"><small>Last updated at {{ date('d M Y', strtotime($product->updated_at))
                          }}
                        </small></div>
                      <div class="mt-2">
                        <!-- Form -->
                        <form id="form_edit_product" action="/product/edit_product/{{ $product->id }}" method="post"
                          enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" name="oldImage" value="{{ $product->image }}">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image">
                            @error('image')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                    </div>
                    <div class="text-center">
                      <span
                        style="background: #108d6f; color:white; padding:0.08em 0.4em;border-radius: 0.5em;cursor:pointer">Admin</span>
                      <div class="text-muted"><small>Created at: {{ date('d M Y', strtotime($product->created_at)) }}
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
                        <div class="row">
                          <div class="col-12 col-sm-4 mb-3">
                            <div class="form-group">
                              <label for="product_name">Product Name</label>
                              <input class="form-control @error('product_name') is-invalid @enderror" type="text"
                                id="product_name" name="product_name" placeholder="Enter product name"
                                value="{{ old('product_name', $product->product_name) }}">
                              @error('product_name')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                          <div class="col-12 col-sm-4 mb-3">
                            <div class="form-group">
                              <label for="egg_size">Egg Size</label>
                              <select class="form-select @error('egg_size') is-invalid @enderror" id="egg_size"
                                name="egg_size">
                                @foreach (['small','medium','large','extra_large'] as $size)
                                <option value="{{ $size }}" {{ old('egg_size', $product->egg_size) === $size ? 'selected' : '' }}>
                                  {{ ucfirst(str_replace('_',' ', $size)) }}
                                </option>
                                @endforeach
                              </select>
                              @error('egg_size')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                          <div class="col-12 col-sm-4 mb-3">
                            <div class="form-group">
                              <label for="quantity_per_unit">Eggs per unit</label>
                              <input class="form-control @error('quantity_per_unit') is-invalid @enderror" type="number"
                                min="6" max="360" id="quantity_per_unit" name="quantity_per_unit"
                                placeholder="e.g. 30"
                                value="{{ old('quantity_per_unit', $product->quantity_per_unit) }}">
                              @error('quantity_per_unit')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-sm-3 mb-3">
                            <div class="form-group">
                              <label for="stock">Stock (units)</label>
                              <input class="form-control @error('stock') is-invalid @enderror" type="number" min="0"
                                id="stock" name="stock" placeholder="Enter available stock"
                                value="{{ old('stock', $product->stock) }}">
                              @error('stock')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                          <div class="col-12 col-sm-3 mb-3">
                            <div class="form-group">
                              <label for="price">Price (per unit)</label>
                              <input class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                                type="number" step="0.01" placeholder="Enter product price"
                                value="{{ old('price', $product->price) }}">
                              @error('price')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                          <div class="col-12 col-sm-3 mb-3">
                            <div class="form-group">
                              <label for="discount">Discount %</label>
                              <input class="form-control @error('discount') is-invalid @enderror" type="number"
                                id="discount" name="discount" placeholder="0"
                                value="{{ old('discount', $product->discount) }}" min="0" max="100">
                              @error('discount')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col mb-3">
                            <div class="form-group">
                              <label for="description">Product Description</label>
                              <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                placeholder="Enter product description" name="description"
                                rows="4">{{ old('description', $product->description) }}</textarea>
                              @error('description')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col d-flex justify-content-end">
                        <a class="btn btn-primary mx-3" href="/product">Back to Product List</a>
                        <button class="btn btn-primary" type="submit" id="button_edit_product">Save Changes</button>
                      </div>
                    </div>
                  </form>
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
@endsection