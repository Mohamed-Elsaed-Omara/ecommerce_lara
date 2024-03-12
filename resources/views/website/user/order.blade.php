@extends('website.layout')
@section('content')
    <section class="cart_section sec_ptb_50 clearfix">
        <div class="container">
            <h2>Your Orders</h2>

            @include('website.user.tabs')

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

                                {{-- Show Model --}}
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
                                                                <th>Price</th>
                                                                <th>Quantity</th>
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
                                                        </tbody>
                                                    </table>
                                                    <div class="row justify-content-lg-end">
                                                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="cart_pricing_table pt-0 text-uppercase"
                                                                data-bg-color="#f2f3f5">
                                                                <h3 class="table_title text-center" data-bg-color="#ededed">
                                                                    Cart Total</h3>
                                                                <ul class="ul_li_block clearfix">
                                                                    <li><span>Subtotal</span>
                                                                        <span>{{ $product->priceText ?? '' }}
                                                                            {{ $subTotal }}</span>
                                                                    </li>
                                                                    <li><span>VAT</span>
                                                                        <span>{{ $product->priceText ?? '' }}
                                                                            {{ $VAT }}</span>
                                                                    </li>
                                                                    <li><span>Total</span>
                                                                        <span>{{ $product->priceText ?? '' }}
                                                                            {{ $total }}</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Canseld Model --}}
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
        </div>
    </section>
@endsection
@section('js')
@endsection
