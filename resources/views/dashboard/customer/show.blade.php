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
        <h1 class="h3 mb-0 text-gray-800">Customers</h1>


    </div>


    <table id="myTable" class="display ">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            ?>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->address }}</td>
                    <td>
                        <!-- Button trigger modal -->
                        <a href="{{ url('admin/customers/'.$user->id) }}" class="btn btn-info">
                            View
                        </a>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal-{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $user->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="cart_table mb_50">
                                            <table class="table">
                                                <thead class="text-uppercase">
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Total Price</th>
                                                    </tr>
                                                </thead>
                                                {{-- <tbody>
                                                    <?php
                                                    $subTotal = 0;
                                                    
                                                    ?>
                                                    @foreach ($order->products as $product)
                                                        <tr>
                                                            <td>
                                                                <div class="cart_product">
                                                                    <div class="item_image">
                                                                        <img src="{{ $product->featura_photo }}"
                                                                            alt="image_not_found">
                                                                    </div>
                                                                    <div class="item_content">
                                                                        <h4 class="item_title">
                                                                            {{ $product->product_name }}</h4>
                                                                        <span
                                                                            class="item_type">{{ $product->category->category_name }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="price_text">{{ $product->priceText }}
                                                                    {{ $product->price }}</span>
                                                            </td>
                                                            <td>
                                                                <div class="quantity_input">
                                                                    <input class="input_number" type="text"
                                                                        value="{{ $product->pivot->quantity }}"
                                                                        disabled>
                                                                </div>
                                                            </td>
                                                            <td><span class="total_price">{{ $product->priceText }}
                                                                    {{ $Total = $product->price * $product->pivot->quantity }}</span>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $subTotal += $Total;
                                                        $VAT = ($subTotal * 15) / 100;
                                                        $total = $subTotal - $VAT;
                                                        ?>
                                                    @endforeach
                                                </tbody> --}}
                                            </table>
                                           
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
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
