@extends('website.layout')
@section('content')
	
<section class="checkout_section sec_ptb_140 clearfix">
	<div class="container">

		
		<div class="order_complete_alart text-center">
			<h2>Congratulation! You’ve <strong>Completed</strong> Order.</h2>
			
			<a href="{{ url('/home') }}" class="btn btn-danger">
				Continue Shopping
			</a>
		</div>

	</div>
</section>
@endsection
@section('js')
	
@endsection