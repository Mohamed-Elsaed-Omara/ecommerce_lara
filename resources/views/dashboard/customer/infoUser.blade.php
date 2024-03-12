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


    <table class="table table-bordered mt-5 bg-white">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Status</th>
                <th scope="col">Payment Method</th>
                <th scope="col">Address</th>
                <th scope="col">Total</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            ?>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $order->statusText }}</td>
                    <td>{{ $order->paymentMethodText }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->created_at->toDayDateTimeString() }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#orderNumber{{ $order->id }}">
                            Show
                        </button>
                        @if ($order->status == App\Models\Order::STATUS_NEW || $order->status == App\Models\Order:: SATUS_IN_PROGRAEC)
                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#orderNumberCanseld{{ $order->id }}">
                                Cansel
                            </button>
                        @endif

                        
                        <div class="modal fade" id="orderNumber{{ $order->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            {{ $order->created_at->toDayDateTimeString() }}</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                    </div>
                                    <div class="modal-body">
                                        <div class="cart_table mb_50">
                                            <table class="table">
                                                <thead class="text-uppercase">
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Photo</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Sub Total</th>
                                                        <th>VAT</th>
                                                        <th>Total Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $subTotal = 0;
                                                    
                                                    ?>
                                                    @foreach ($order->products as $product)
                                                        <tr>
                                                            <td>
                                                                <div class="cart_product">
                                                                    <div class="item_content">
                                                                        <h4 class="item_title">
                                                                            {{ $product->product_name }}</h4>
                                                                        <span
                                                                            class="item_type">{{ $product->category->category_name }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="item_image">
                                                                    <img src="{{ $product->featura_photo }}"
                                                                        alt="image_not_found">
                                                                </div>
                                                            </td>
                                                            
                                                            <td>
                                                                <span class="quantity_input">
                                                                        {{ $product->pivot->quantity }}
                                                                </span>
                                                                        
                                                            </td>
                                                            <td>
                                                                <span class="price_text">
                                                                        {{ $product->price }}
                                                                </span>
                                                                        
                                                            </td>
                                                            <td><span class="total_price">{{ $product->priceText }}
                                                                {{ $Totall = $product->price * $product->pivot->quantity }}</span>
                                                            </td>
                                                            <?php
                                                            $subTotal += $Totall;
                                                            
                                                            ?>
                                                            <td>
                                                                <span class="vat_text">
                                                                        {{$VAT = ($subTotal * 15) / 100 }}
                                                                </span>
                                                                        
                                                            </td>
                                                            <td>
                                                                <span class="total_text">
                                                                        {{ $subTotal - $VAT }}
                                                                </span>
                                                                        
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade" id="orderNumberCanseld{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are You Sure To Delete This Order
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    <form action="{{ url('orders/'.$order->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>


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
@endsection
@push('scripts')
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
@endpush
