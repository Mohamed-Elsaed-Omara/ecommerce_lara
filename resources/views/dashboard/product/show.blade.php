@extends('dashboard/layout')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Details Product</h1>

        <a href="{{ url('admin/products') }}" class="btn btn-primary">
            <i class="fas fa-step-backward"></i>
            Back to Products
        </a>
    </div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            show product
        </h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{ $product->product_name }}</td>
                </tr>
                <tr>
                    <th>Category Name</th>
                    <td>{{ $product->category->category_name }}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>{{ $product->price }}</td>
                </tr>
                <tr>
                    <th>Stock</th>
                    <td>{{ $product->stock_quantity }}</td>
                </tr>
                <tr>
                    <th>SKU</th>
                    <td>{{ $product->sku }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $product->description }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            photos
        </h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            @foreach ($product->photos as $photo)
                <img src="{{ asset($photo->path) }}" width="300px" height="200" class="img-thumbnail" alt="{{ $photo->path }}">
            @endforeach
        </table>
    </div>
</div>
    
@endsection
@push('scripts')
@endpush
