@extends('website.layout')
@section('content')
	<section class="cart_section sec_ptb_50 clearfix">
		<div class="container">
			<h2>Your Cart</h2>
		<form action="{{ url('update-cart') }}" method="POST">
			@csrf
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
						@forelse ($products as $product)
						<tr>
							<td>
								<div class="cart_product">
									<div class="item_image">
										<img src="{{ $product->featura_photo }}" alt="image_not_found">
									</div>
									<div class="item_content">
										<h4 class="item_title">{{ $product->product_name }}</h4>
										<span class="item_type">{{ $product->category->category_name }}</span>
									</div>
									<form action="{{ url('remove-from-cart/'. $product->id) }}" method="POST">
										@csrf
										<button type="submit" class="remove_btn">
											<i class="fal fa-times"></i>
										</button>
									</form>
								</div>
							</td>
							<td>
								<span class="price_text">{{ $product->priceText }} {{ $product->price }}</span>
							</td>
							<td>
								<div class="quantity_input">
									
										<span class="input_number_decrement">–</span>
										<input class="input_number" type="text" value="{{ $product->pivot->quantity }}" name="quantity[{{ $product->id }}]">
										<span class="input_number_increment">+</span>
									
								</div>
							</td>
							<td><span class="total_price">{{ $product->priceText }} {{ $product->price *  $product->pivot->quantity}}</span></td>
						</tr>
						
						@empty
							<tr>
								<td colspan="100%">
									<div class="alert alert-info text-center">
										Your cart is empty!
									</div>
								</td>
							</tr>
						@endforelse
							

						
					</tbody>
				</table>
			</div>

			<div class="coupon_wrap mb_50">
				<div class="row justify-content-lg-between">
					

					<div class="col">
						<div class="cart_update_btn">
							<button type="submit" class="custom_btn bg_secondary text-uppercase">Update Cart</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="row">
			<div class="col-4">
				<div class="coupon_form">
					@if (session('erorr_coupon'))
					<div class="alert alert-danger">
						{{ session('erorr_coupon') }}
					</div>
						
					@endif
					<form action="{{ url('apply-coupon') }}" method="POST">
						@csrf
						<div class="form_item mb-0">
							<input type="text" class="coupon" placeholder="Coupon Code" name="code" value="{{ $_GET['code'] ?? ''}}">
						</div>
						<button type="submit" class="custom_btn bg_danger text-uppercase">
							Apply Coupon
						</button>
					</form>
				</div>
			</div>
		</div>
			<div class="row justify-content-lg-end">
				<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
					<div class="cart_pricing_table pt-0 text-uppercase" data-bg-color="#f2f3f5">
						<h3 class="table_title text-center" data-bg-color="#ededed">Cart Total</h3>
						<ul class="ul_li_block clearfix">
							<li><span>Subtotal</span> <span>{{$product->priceText?? '' }} {{ $subTotal }}</span></li>
							<li><span>VAT</span> <span>{{ $product->priceText ?? '' }} {{ $VAT }}</span></li>
							<li><span>Total</span> <span>{{ $product->priceText?? '' }} {{ $total }}</span></li>
						</ul>
						<a href="{{ url('/check-out') }}" class="custom_btn bg_success">Proceed to Checkout</a>
					</div>
				</div>
			</div>

		</div>
	</section>
		
@endsection
@section('js')
	
@endsection