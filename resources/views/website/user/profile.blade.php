@extends('website.layout')
@section('content')
	<section class="cart_section sec_ptb_50 clearfix">
		<div class="container">
			<h2>Your Profile</h2>
			
			@include('website.user.tabs')

			<form method="POST" action="{{ url('/profile') }}" class="pt-5">
				@csrf
				<div class="reg_form">
					
					<div class="form_item">
						<input type="text" name="name" placeholder="Name"  value="{{ auth()->user()->name }}">
						@error('name')
							<div class="text-danger">{{ $message }}</div>
						@enderror
					</div>
					
					<div class="form_item">
						<input type="email" name="email" placeholder="Email" value="{{ auth()->user()->email }}">
						@error('email')
							<div class="text-danger">{{ $message }}</div>
						@enderror
					</div>

					<div class="form_item">
						<input type="text" name="phone" placeholder="Phone" value="{{ auth()->user()->phone }}">
					</div>

					<div class="form_item">
						<textarea name="address" >{{ auth()->user()->addrres }}</textarea>
					</div>
					
					<button type="submit" class="custom_btn bg_default_red text-uppercase mb_50">Update Account</button>

				</div>
			</form>
		</div>
	</section>
		
@endsection
@section('js')
	
@endsection