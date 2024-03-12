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
        <h1 class="h3 mb-0 text-gray-800">Orders</h1>


    </div>
    <form action="{{ url('admin/orders') }}" method="GET">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option value="">All</option>
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>New</option>
                        <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>In Progress</option>
                        <option value="3" {{ old('status') == 3 ? 'selected' : '' }}>Shipped</option>
                        <option value="4" {{ old('status') == 4 ? 'selected' : '' }}>Paid</option>
                        <option value="5" {{ old('status') == 5 ? 'selected' : '' }}>Canceled</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label>Payment Method</label>
                    <select class="form-control" name="payment_method">
                        <option value="">All</option>
                        <option value="1" {{ old('payment_method') == 1 ? 'selected' : '' }}>Cash On Delivary</option>
                        <option value="2" {{ old('payment_method') == 2 ? 'selected' : '' }}>PayPal</option>

                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label>From Date</label>
                    <input type="date" class="form-control" value="{{ old('from_order_date') }}" name="from_order_date">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label>To Date</label>
                    <input type="date" class="form-control" value="{{ old('to_order_date') }}" name="to_order_date">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered mt-5 bg-white">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Status</th>
                <th scope="col">Payment_method</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
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
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->user->email }}</td>
                    <td>{{ $order->user->phone }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->created_at->toDayDateTimeString() }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#orderNumber{{ $order->id }}">
                            Show
                        </button>
                        @if ($order->status == App\Models\Order::STATUS_NEW || $order->status == App\Models\Order::SATUS_IN_PROGRAEC)
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
                                                                    {{ $VAT = ($subTotal * 15) / 100 }}
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
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="orderNumberCanseld{{ $order->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are You Sure To Delete This Order
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <form action="{{ url('orders/' . $order->id) }}" method="POST">
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
    {{ $orders->links() }}

@endsection
@push('scripts')
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
@endpush
