@extends('website.layout')
@section('content')
<!-- slider_section - start
			================================================== -->
			@include('website.partials.slider')
			<!-- slider_section - end
			================================================== -->


			<!-- policy_section - start
			================================================== -->
			<section class="policy_section sec_ptb_50 pb-0 clearfix">
				<div class="container maxw_1460">
					<div class="supermarket_policy clearfix">
						<ul class="ul_li clearfix">
							<li>
								<div class="supermarket_policy_item clearfix">
									<div class="item_icon">
										<img src="assets/images/icons/supermarket/icon_12.png" alt="icon_not_found">
									</div>
									<div class="item_content">
										<h3 class="text-uppercase">Free Delivery</h3>
										<p>For all order over $120</p>
									</div>
								</div>
							</li>

							<li>
								<div class="supermarket_policy_item clearfix">
									<div class="item_icon">
										<img src="assets/images/icons/supermarket/icon_13.png" alt="icon_not_found">
									</div>
									<div class="item_content">
										<h3 class="text-uppercase">Safe payment</h3>
										<p>100% secure payment</p>
									</div>
								</div>
							</li>

							<li>
								<div class="supermarket_policy_item clearfix">
									<div class="item_icon">
										<img src="assets/images/icons/supermarket/icon_14.png" alt="icon_not_found">
									</div>
									<div class="item_content">
										<h3 class="text-uppercase">Shop with confidence</h3>
										<p>If goods have problems</p>
									</div>
								</div>
							</li>

							<li>
								<div class="supermarket_policy_item clearfix">
									<div class="item_icon">
										<img src="assets/images/icons/supermarket/icon_15.png" alt="icon_not_found">
									</div>
									<div class="item_content">
										<h3 class="text-uppercase">24/7 help center</h3>
										<p>Dedicated 24/7 support</p>
									</div>
								</div>
							</li>

							<li>
								<div class="supermarket_policy_item clearfix">
									<div class="item_icon">
										<img src="assets/images/icons/supermarket/icon_16.png" alt="icon_not_found">
									</div>
									<div class="item_content">
										<h3 class="text-uppercase">Friendly services</h3>
										<p>30 day satisfaction guarantee</p>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</section>
			<!-- policy_section - end
			================================================== -->


			<!-- deals_section - start
			================================================== -->
			@include('website.partials.deals')
			<!-- deals_section - end
			================================================== -->



			


			<!-- bestseller_section - start
			================================================== -->
			<section class="bestseller_section sec_ptb_50 pb-0 clearfix">
				<div class="container maxw_1460">

					<div class="row mb_50 align-items-center justify-content-lg-between">
						<div class="col-lg-5">
							<div class="supermarket_section_title clearfix">
								<span class="sub_title text-uppercase">A wide selection of items</span>
								<h2 class="title_text mb-0">Bestseller Products</h2>
							</div>
						</div>

						<div class="col-lg-7">
							<ul class="supermarket_tab_nav ul_li_right nav clearfix" role="tablist">
								{{-- <li>
									<a class="active" data-toggle="tab" href="#top_tab">Top 20</a>
								</li> --}}
								@foreach ($categories as $category)
								<li>
									<a data-toggle="tab" class="{{ $loop->first ? 'active' : '' }}" href="#tab{{ $category->id }}">{{Str::title($category->category_name) }}</a>
								</li>
								@endforeach
							</ul>
						</div>
					</div>

					<div class="tab-content">
						
						@foreach ($categories as $category)
							<div id="tab{{ $category->id }}" class="tab-pane {{ $loop->first ? 'active' : 'fade'}}">
								<ul class="supermarket_product_columns has_3columns ul_li bg_white clearfix">
									@foreach ($category->products as $product)
										<li>
											<div class="supermarket_product_listlayout">
												<div class="slideshow1_slider item_image" data-slick='{"arrows": false}'>
													@foreach ($product->photos as $photo)
														
													<div class="item">
														<img src="{{ asset($photo->path) }}" alt="image_not_found">
													</div>
													@endforeach
													
												</div>
												<div class="item_content">
													<span class="item_type text-uppercase" data-bg-color="#0062bd">Watch</span>
													<div class="rating_star_wrap d-flex align-items-center clearfix">
											
														{{-- <div class="pp-rating"></div>
														
														<input type="hidden" name="rate" id="g-rate" data-pid="{{ $product->rating }}">
														<span class="rating_value">{{ $product->pivot->rating }}.0</span>
														--}}
													
													</div>
													<h3 class="item_title">
														<a href="#!">{{ $product->product_name }}</a>
													</h3>
													<ul class="product_action_btns ul_li clearfix">
														<li><a class="addtocart_btn tooltips" data-placement="top" title="Add To Cart" href="{{ url('product/'.$product->id) }}">Start Buying</a></li>
													</ul>
													<ul class="info_list ul_li_block clearfix">
														
														<li>
															<div class="item_icon">
																<i class="fal fa-truck-moving"></i>
															</div>
															<div class="item_content">
																<p class="mb-0">
																	Total: {{ $product->sales }} orders
																</p>
															</div>
														</li>
														<li>
															<div class="item_icon">
																<i class="fal fa-truck-moving"></i>
															</div>
															<div class="item_content">
																<p class="mb-0">
																	price: {{ $product->price }} 
																</p>
															</div>
														</li>
													</ul>
												</div>
											</div>
										</li>
									@endforeach
								</ul>
							</div>
						@endforeach
					</div>
				</div>
			</section>
			<!-- bestseller_section - end
			================================================== -->


			
@endsection