{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

 --}}

@extends('website.layout')
@section('content')
                    

			<!-- register_section - start
			================================================== -->
			<section class="register_section sec_ptb_140 parallaxie clearfix" data-background="assets/images/backgrounds/bg_23.jpg">
				<div class="container">
					<div class="reg_form_wrap signup_form" data-background="assets/images/reg_bg_02.png">
						<form method="POST" action="{{ route('register') }}">
							@csrf
							<div class="reg_form">
								<h2 class="form_title text-uppercase">Register</h2>
								<div class="form_item">
									<input type="text" name="name" placeholder="Name"  value="{{ old('name') }}">
									@error('name')
    									<div class="text-danger">{{ $message }}</div>
									@enderror
								</div>
								
								<div class="form_item">
									<input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
									@error('email')
    									<div class="text-danger">{{ $message }}</div>
									@enderror
								</div>
								
								
								<div class="form_item">
									<input type="password" name="password" placeholder="Password">
									@error('password')
    									<div class="text-danger">{{ $message }}</div>
									@enderror
								</div>
								

								<div class="form_item">
									<input type="password" name="password_confirmation" placeholder="Confirm Password">
									
								</div>
								
								
								<button type="submit" class="custom_btn bg_default_red text-uppercase mb_50">Create Account</button>
								<div class="social_wrap mb_100">
                                    <h4 class="small_title_text mb_15 text-center text-uppercase">Or Login With</h4>
                                    <ul class="circle_social_links ul_li_center clearfix">
                                        <li><a data-bg-color="#3b5998" href="{{ route('auth.socialite.redirect','facebook') }}"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a data-bg-color="#ea4335" href="{{ route('auth.socialite.redirect','google') }}"><i class="fab fa-google-plus-g"></i></a></li>
                                    </ul>
                                </div>
								<div class="create_account text-center">
									<h4 class="small_title_text text-center text-uppercase">Have not account yet?</h4>
									<a class="create_account_btn text-uppercase" href="{{ url('login') }}">Login</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</section>
			<!-- register_section - end
			================================================== -->


		
		<!-- main body - end
		================================================== -->



@endsection 