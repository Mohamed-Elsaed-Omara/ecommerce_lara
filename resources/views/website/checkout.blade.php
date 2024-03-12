@extends('website.layout')
@section('content')
	<section class="checkout_section sec_ptb_50 clearfix">
		<div class="container">
			<form action="{{ url('/create-order') }}" method="POST">
				@csrf
				<div class="billing_form mb_50">
					<h3 class="form_title mb_30">Billing details</h3>
			
						<div class="form_wrap">

							<div class="form_item">
								<span class="input_title">Address<sup>*</sup></span>
								<textarea type="text" name="address" placeholder="House number and street name"></textarea>
							</div>

							<hr>

							<div class="form_item mb-0">
								<span class="input_title">Order notes</span>
								<textarea name="notes" placeholder="Note about your order, eg. special notes fordelivery."></textarea>
							</div>

						</div>
					
				</div>

				<div class="billing_form">
					<h3 class="form_title mb_30">Payment Method</h3>
					
						<div class="form_wrap">

							<div class="billing_payment_mathod">
								<ul class="ul_li_block clearfix">
									
									<li>
										<div class="checkbox_item mb-0 pl-0">
											<label for="cash_delivery">
												<input id="cash_delivery" type="radio" name="payment_method" value="1" checked>
												Cash On Delivery
											</label>
										</div>
									</li>
									<li>
										<div class="checkbox_item mb-0 pl-0">
											<label for="paypal_checkbox">
												<input id="paypal_checkbox" type="radio" name="payment_method" value="2">
												Paypal 
												<a href="#!">
													<img class="paypal_image" src="assets/images/payment_methods_03.png" alt="image_not_found">
												</a>
											</label>
										</div>
									</li>
								</ul>
								<button type="submit" class="custom_btn bg_default_red">PLACE ORDER</button>
							</div>

						</div>
					
				</div>
			</form>
		</div>
	</section>

@endsection
@section('js')
	
@endsection