<div class="popular_products_area">
    <h3 class="title_text mb_30">Popular Products</h3>
    <div class="popular_products_carousel arrow_ycenter mt__30">
        <div class="slideshow4_slider row" data-slick='{"dots": false}'>
            @foreach ($products as $product)
                
            <div class="col item">
                <div class="ecommerce_product_grid">
                    <ul class="product_label ul_li clearfix">
                        <li class="bg_leafgreen">{{ $product->views }} VIEWS</li>
                    </ul>

                    <div class="tab-content">
                        @foreach ($product->photos as $photo)
                        
                        <div id="ptab1_1" class="tab-pane {{ $loop->first ? 'active' : '' }}">
                            <div class="item_image">
                                <img src="{{ $photo->path }}" alt="image_not_found">
                            </div>
                        </div>
                        @endforeach
                        <ul class="product_action_btns ul_li_center clearfix">
                            <li><a class="tooltips"  title="Product View" href="{{ url('product/'.$product->id) }}" ><i class="fal fa-shopping-basket"></i></a></li>
                        </ul>
                    </div>
                    <div class="item_content">
                        <h3 class="item_title">
                            <a href="#!">{{ $product->product_name }}</a>
                        </h3>
                        <ul class="product_color ul_li nav clearfix">
                            <li class="active"><a class="pbg_brown" data-toggle="tab" href="#ptab1_1"></a></li>
                            <li><a class="pbg_olivegreen" data-toggle="tab" href="#ptab1_2"></a></li>
                            <li><a class="pbg_gray" data-toggle="tab" href="#ptab1_3"></a></li>
                        </ul>
                        <span class="item_price"><strong>{{ $product->priceText }} {{ $product->price }}</strong></span>
                    </div>
                </div>
            </div>
            @endforeach

           

            
        </div>
        <div class="carousel_nav">
            <button type="button" class="ss4_left_arrow"><i class="fal fa-angle-left"></i></button>
            <button type="button" class="ss4_right_arrow"><i class="fal fa-angle-right"></i></button>
        </div>
    </div>
</div>