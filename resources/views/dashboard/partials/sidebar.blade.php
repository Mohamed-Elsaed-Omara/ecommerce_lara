<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">lara-shop</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/admin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    
    
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item active">
        <a class="nav-link collapsed" href="{{ url('admin/categories') }}">
            <i class="fas fa-archive"></i>
            <span>Categories</span>
        </a>
    </li>
    
    <hr class="sidebar-divider">
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item active">
        <a class="nav-link collapsed" href="{{ url('admin/products') }}">
            <i class="fas fa-cart-plus"></i>
            <span>Products</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item active">
        <a class="nav-link collapsed" href="{{ url('admin/customers') }}">
            <i class="fas fa-users"></i>
            <span>Customers</span>
        </a>
    </li>
    
    <hr class="sidebar-divider">
    
    <li class="nav-item active">
        <a class="nav-link collapsed" href="{{ url('admin/orders') }}">
            <i class="fas fa-truck"></i>
            <span>Orders</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    
    <li class="nav-item active">
        <a class="nav-link collapsed" href="{{ url('admin/deals') }}">
            <i class="fas fa-fire"></i>
            <span>Deals</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    
    <li class="nav-item active">
        <a class="nav-link collapsed" href="{{ url('admin/coupons') }}">
            <i class="fas fa-gift"></i>
            <span>Coupouns</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    
    <li class="nav-item active">
        <a class="nav-link collapsed" href="{{ url('admin/slides') }}">
            <i class="fas fa-tasks"></i>
            <span>Sliders</span>
        </a>
    </li>
</ul>