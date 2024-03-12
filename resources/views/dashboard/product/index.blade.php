@extends('dashboard/layout')
@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endsection

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
        <h1 class="h3 mb-0 text-gray-800">Products</h1>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-plus"></i>
            Add Product
        </button>
    </div>


    <!--add Modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/products') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Category Name</label>
                            <select class="form-control" name="category_id">
                                <option disabled selected>--Select Category--</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Name</label>
                            <input type="text" name="product_name" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" >
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" class="form-control"  name="price" value="0">
                        </div>
                        <div class="form-group">
                            <label for="inputStock">Stock</label>
                            <input type="number" class="form-control" id="inputStock" name="stock_quantity" value="0">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Description</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Photos</label>
                            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="photos[]" multiple accept="image/*">
                        </div>
                        

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table id="myTable" class="display ">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Category Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>

            @foreach ($products as $product)
                <?php $i++; ?>
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->category->category_name }}</td>
                    <td>
                        <a href="{{ url('admin/products/'.$product->id) }}" class="btn btn-primary btn-sm" 
                            title="Show Product"><i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ url('admin/products/'.$product->id.'/edit') }}" class="btn btn-info btn-sm"
                            title="Edit Product"><i class="fa fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#delete{{ $product->id }}" title="Delete Product"><i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <!-- delete_modal_Grade -->
                <div class="modal fade" id="delete{{ $product->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                    Delete Product
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('admin/products/'.$product->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    Are you sure to delete the {{ $product->product_name }} product
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit"
                                            class="btn btn-danger">Dlete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
@endsection
@push('scripts')
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
@endpush
