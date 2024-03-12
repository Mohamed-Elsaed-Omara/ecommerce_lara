@extends('dashboard.layout')
@section('titel')
slides
@endsection
@section('content')
    <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">slides</h1>
        <a href="{{ url('admin/coupons') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        Back To slides</a>
</div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">New slide</h6>
        </div>
        

        <div class="card-body">

            @if (session('success'))
                
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                
            @endif
        <form action="{{ url('admin/slides') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Products</label>
                    <select class="custom-select" name="product_id">
                        <option selected value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{$product->id}}"> {{$product->product_name}}</option>
                        @endforeach
                    </select>
                        @error('product_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                </div>

                <div class="form-group">
                    <label>Content</label>
                    <textarea name="content" class="form-control content" rows="10"></textarea>
                    @error('content')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Photo</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="photo"> 
                    @error('photo')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
        
    </div>


@endsection