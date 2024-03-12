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
        <h1 class="h3 mb-0 text-gray-800">Categories</h1>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-plus"></i>
            Add Category
        </button>
    </div>


    <!-- Modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/categories') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Category Name</label>
                            <input type="text" name="category_name" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" >
                        </div>
                        <label for="exampleFormControlFile1">Photo</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="photo"> 

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
                <th>Photo</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>

            @foreach ($category as $cate)
                <?php $i++; ?>
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $cate->category_name }}</td>
                    <td>
                        <img src="{{ asset($cate->photo) }}" width="200px"  alt="">
                    </td>
                    <td>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                            data-target="#edit{{ $cate->id }}" title="Edit Category"><i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#delete{{ $cate->id }}" title="Delete Category"><i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <!-- edit_modal_Grade -->
                <div class="modal fade" id="edit{{ $cate->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('admin/categories/' . $cate->id) }}" method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Category Name</label>
                                        <input type="text" name="category_name" class="form-control"
                                            id="exampleInputEmail1" value="{{ $cate->category_name }}"
                                            aria-describedby="emailHelp">
                                    </div>
                                    <label for="exampleFormBestSalers">BestSalers</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input type="checkbox" name="bestsalers" value="1" {{ $cate->bestsalers === 1 ? 'checked' : '' }} id="exampleFormBestSalers">
                                            </div>
                                        </div>
                                    <label for="exampleFormControlFile1">Photo</label>
                                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="photo"> 

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Data</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- delete_modal_Grade -->
                <div class="modal fade" id="delete{{ $cate->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                    Delete Category
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('admin/categories/'.$cate->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    Are you sure to delete the {{ $cate->category_name }}?
                                    <input id="id" type="hidden" name="id" class="form-control"
                                        value="{{ $cate->id }}">
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
