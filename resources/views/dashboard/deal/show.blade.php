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
        <h1 class="h3 mb-0 text-gray-800">FlashDeals</h1>

        <a href="{{ url('admin/deals/create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            New Deal
        </a>
    </div>


    <table class="table table-bordered mt-5 bg-white">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Product</th>
                <th scope="col">Discount</th>
                <th scope="col">Duration</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            
            @forelse ($deals as $deal)
                <tr>
                    <td>{{ $deal->name }}</td>
                    <td>{{ $deal->product->product_name }}</td>
                    <td>{{ $deal->discount }} %</td>
                    <td>{{ $deal->duration }} hrs</td>
                    <td>{{ $deal->active ? 'active' : 'expired' }}</td>
                    <td>
                        
                        <a href="{{ url('admin/deals/'.$deal->id.'/edit') }}" class="btn btn-info btn-sm"
                            title="Edit Product"><i class="fa fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#delete{{ $deal->id}}" title="Delete Product"><i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <div class="modal fade" id="delete{{ $deal->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                    Delete Deal
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('admin/deals/'.$deal->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    Are you sure to delete the deal{{ $deal->id}}
                                    
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


            @empty
                <tr>
                    <td colspan="100%">
                        <div class="alert alert-warning text-center">
                            No Orders Available.
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $deals->links() }}

   

    
@endsection
@push('scripts')
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
@endpush
