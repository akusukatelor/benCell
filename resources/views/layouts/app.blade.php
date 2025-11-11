<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('style')

    <!-- CSS Override untuk Guest (Login/Register) - Hanya aktif jika belum login -->
    @guest
<style>

/* ========== Background animasi gelombang ========== */
body.login-mode {
    margin: 0;
    padding: 0;
    height: 100vh;
    background: url('{{ asset("img/gelombang.svg") }}') repeat;
    background-size: cover;
    animation: rotate 6s infinite alternate linear;
    overflow: hidden;
}


/* Animasi background */
@keyframes rotate {
    100% {
        background-position: 15% 50%;
    }
}

/* ========== Hilangkan elemen dashboard untuk guest ========== */
.main-header,
.main-sidebar,
.main-footer {
    display: none !important;
}

/* ========== Wrapper supaya tidak menutupi background ========== */
.wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    width: 100vw;
    margin: 0;
    padding: 0;
}

.content-wrapper, section.content {
    background: transparent !important;
    box-shadow: none !important;
    width: 100%;
    height: 100%;
     padding: 0 !important;
    margin: 0 !important;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* ========== Login Box agar tetap rapih di tengah ========== */
.login-box {
    width: 100%;
    max-width: 380px;
    margin: 0;
}

.login-box .card {
    background: #ffffff !important;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
    padding: 20px;
    
}

</style>
@endguest

</head>
<body class="@guest login-mode @else hold-transition sidebar-mini @endguest">
<div class="wrapper">

  <!-- Navbar -->
  @auth
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        
        <!-- Profile Dropdown -->
@if(Auth::check())
<li class="nav-item dropdown">
    <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
    <img src="{{ Auth::user()->profile_photo_url }}"
         class="img-circle elevation-2 mr-2"
         width="30" height="30" alt="User Image"
         style="object-fit: cover;">
    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
    <i class="fas fa-caret-down ml-1"></i>
</a>

    <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="{{ route('profile.edit') }}">
            <i class="fas fa-user mr-2"></i> Profile
        </a>
        <div class="dropdown-divider"></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
    </div>
</li>
@endif

    </ul>
  </nav>
  @endauth

<!-- Sidebar -->
  @auth
  <aside class="main-sidebar sidebar-light elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link text-center" style="padding: 10px 15px;">
      <img src="{{ asset('img/bencell-logo.png') }}" alt="BenCell Logo" class="img-fluid" style="max-height: 40px; width: auto;">
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">

          <li class="nav-item">
  <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>Dashboard</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-box"></i>
    <p>Produk</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-tags"></i>
    <p>Kategori</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-money-bill-wave"></i>
    <p>Transaksi</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('service-orders.index') }}" class="nav-link {{ request()->routeIs('service-orders.*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-tools"></i>
    <p>Pesanan Service</p>
  </a>
</li>


        </ul>
      </nav>
    </div>
  </aside>
  @endauth

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content p-3">
      @yield('content')
    </section>
  </div>

  <!-- Footer -->
  
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
   @stack('scripts')
</body>
</html>
