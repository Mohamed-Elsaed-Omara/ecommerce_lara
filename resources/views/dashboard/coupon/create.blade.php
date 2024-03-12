@extends('dashboard.layout')
@section('titel')
Coupons
@endsection
@section('content')
    <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Coupons</h1>
        <a href="{{ url('admin/coupons') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        Back To Coupons</a>
</div>


<form action="{{ url('admin/coupons') }}" method="POST" >
    @csrf
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">New Coupons</h6>
        </div>
        

        <div class="card-body">

            @if (session('success'))
                
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                
            @endif
                <div class="form-group">
                    <label >Name</label>
                    <input type="text" class="form-control" name="code">                  
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Type</label>
                    <select class="custom-select" name="type">
                        <option selected value="">Select Type</option>
                            <option value="1">Fixed</option>
                            <option value="2">Percent</option>
                    </select>
                        @error('type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                </div>

                <div class="form-group">
                    <label>Discount</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                        </div>
                        <input type="text" class="form-control" name="discount">
                    </div>
                    @error('discount')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Redeems</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                        </div>
                        <input type="text" class="form-control" name="redeems">
                    </div>
                    @error('redeems')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        
    </div>
</form>

@endsection