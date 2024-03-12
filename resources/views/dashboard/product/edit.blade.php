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
        <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>

        <a href="{{ url('admin/products') }}" class="btn btn-primary">
            <i class="fas fa-step-backward"></i>
            Back to Products
        </a>
    </div>
    <form action="{{ url('admin/products/'.$product->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="exampleFormControlSelect1">Category Name</label>
            <select class="form-control" name="category_id">
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                @endforeach
                
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Product Name</label>
            <input type="text" name="product_name" class="form-control" id="exampleInputEmail1"
                    value="{{ $product->product_name }}">
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="text" class="form-control"  name="price" value="{{ $product->price }}">
        </div>
        <div class="form-group">
            <label for="inputStock">Stock</label>
            <input type="number" class="form-control" id="inputStock" name="stock_quantity" value="{{ $product->stock_quantity }}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Description</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description">{{ $product->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleFormControlFile1">Photos</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="photos[]" multiple accept="image/*">
        </div>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Data</button>
    </form>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            photos
        </h6>
    </div>
    <div class="card-body row">
        <table class="table table-bordered">
            @foreach ($product->photos as $photo)
            <div class="img-box col">
                <img src="{{ asset($photo->path) }}" class="img-thumbnail" alt="{{ $photo->path }}">
                <a href="{{ url('admin/remove-img'.$photo->id) }}" class="del-img">
                    <img src="{{ asset('dashboard/img/remove.png') }}" class="w-25" >
                </a>
            </div>
            @endforeach
        </table>
    </div>
</div>
    
@endsection
@push('scripts')
@endpush
