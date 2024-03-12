	<ul class="nav nav-tabs">
		<li class="nav-item">
		<a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" href="{{ url('/profile') }}">Personal Info</a>
		</li>
		<li class="nav-item">
		<a class="nav-link {{ request()->is('orders') ? 'active' : ''}}" href="{{ url('/orders') }}">Orders</a>
		</li>
		<li class="nav-item">
		<a class="nav-link {{ request()->is('change-password') ? 'active' : ''}}" href="{{ url('/change-password') }}">Change_Password</a>
		</li>
	</ul>

	@if (session('success'))
		<div class="col">
			<div class="alert alert-success">
				{{ session('success') }}
			</div>
		</div>
	@endif

	@if (session('error'))
		<div class="col">
			<div class="alert alert-success">
				{{ session('error') }}
			</div>
		</div>
	@endif
