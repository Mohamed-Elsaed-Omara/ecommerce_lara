
@extends('website.layout')
@section('content')
                    
        <!-- register_section - start
            ================================================== -->
            <section class="register_section sec_ptb_140 has_overlay parallaxie clearfix"
                data-background="assets/images/backgrounds/bg_22.jpg">
                <div class="overlay" data-bg-color="rgba(55, 55, 55, 0.75)"></div>
                <div class="container">
                    <div class="reg_form_wrap login_form" data-background="assets/images/reg_bg_01.png">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="reg_form">
                                <h2 class="form_title text-uppercase text-center">Login</h2>
                                <div class="form_item">
    
                                    <input id="username_input" type="email" name="email" placeholder="username" required 
                                    value="{{ old('email') }}">
                                    @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <label for="username_input"><i class="fal fa-user"></i></label>
                                </div>
                                <div class="form_item">
    
                                    <input id="password_input" type="password" name="password" placeholder="password" required>
                                    <label for="password_input"><i class="fal fa-unlock-alt"></i></label>
                                </div>
    
                                {{-- <a class="forget_pass text-uppercase mb_30" href="#!">Forgot password?</a> --}}
                                @if (Route::has('password.request'))
                                    <a class="forget_pass text-uppercase mb_30" href="{{ route('password.request') }}">
                                        Forgot password?
                                    </a>
                                @endif
                                <button type="submit" class="custom_btn bg_default_red text-uppercase mb_50">Login</button>
    
                                <div class="social_wrap mb_100">
                                    <h4 class="small_title_text mb_15 text-center text-uppercase">Or Login With</h4>
                                    <ul class="circle_social_links ul_li_center clearfix">
                                        <li><a data-bg-color="#3b5998" href="{{ route('auth.socialite.redirect','facebook') }}"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a data-bg-color="#ea4335" href="{{ route('auth.socialite.redirect','google') }}"><i class="fab fa-google-plus-g"></i></a></li>
                                    </ul>
                                </div>
    
                                <div class="create_account text-center">
                                    <h4 class="small_title_text text-center text-uppercase">Have not account yet?</h4>
                                    <a class="create_account_btn text-uppercase" href="{{ url('register') }}">Sign Up</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <!-- register_section - end
                ================================================== -->
                
@endsection 
            
