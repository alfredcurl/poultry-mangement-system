@extends('layouts.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        @include('partials.breadcumb', ['title' => $title, 'items' => ['Reports', 'Inventory']])

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-dove me-1"></i>
                        Bird Inventory
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Batch</th>
                                    <th>Status</th>
                                    <th class="text-end">Current Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($birds as $bird)
                                    <tr>
                                        <td>{{ $bird->bird_type }} - {{ $bird->breed }}</td>
                                        <td>{{ ucfirst($bird->status) }}</td>
                                        <td class="text-end">{{ number_format($bird->current_quantity) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No birds found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-seedling me-1"></i>
                        Feed Inventory
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Feed</th>
                                    <th class="text-end">Remaining (kg)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($feeds as $feed)
                                    <tr>
                                        <td>{{ $feed->feed_name }}</td>
                                        <td class="text-end">{{ number_format($feed->remaining, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No feed stock</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-pills me-1"></i>
                        Medication Inventory
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Medication</th>
                                    <th class="text-end">Remaining</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($medications as $medication)
                                    <tr>
                                        <td>{{ $medication->medication_name }}</td>
                                        <td class="text-end">{{ number_format($medication->remaining, 2) }} {{ $medication->unit }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No medication stock</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-egg me-1"></i>
                        Egg Products
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Size</th>
                                    <th class="text-end">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($eggProducts as $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ ucfirst($product->egg_size) }}</td>
                                        <td class="text-end">{{ number_format($product->stock) }} units</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No egg products</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

