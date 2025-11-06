<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- CSS Override untuk Guest (Login/Register) - Hanya aktif jika belum login -->
    @guest
    <style>
        /* Force background biru muda di seluruh halaman untuk guest */
        body.hold-transition,
        body.hold-transition * {
            background-color: #ecf0f5 !important; /* Biru muda default AdminLTE */
            background-image: none !important; /* Hilangkan pattern jika ada */
            color: inherit !important;
        }
        .wrapper {
            display: flex !important;
            flex-direction: column !important;
            min-height: 100vh !important;
            background-color: #ecf0f5 !important; /* Biru muda */
            padding: 0 !important;
            margin: 0 !important;
        }
        .content-wrapper {
            margin-left: 0 !important; /* Hilangkan margin kiri dari sidebar */
            margin-right: 0 !important;
            width: 100% !important;
            flex: 1 !important; /* Grow untuk isi ruang tengah */
            background-color: #ecf0f5 !important; /* Biru muda, override white */
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 !important;
            min-height: auto !important;
        }
        .content-wrapper > section.content {
            padding: 20px !important; /* Padding ringan */
            margin: 0 auto !important;
            width: 100% !important;
            max-width: 400px !important;
            background-color: transparent !important; /* Tidak tambah white */
            box-shadow: none !important; /* Hilangkan shadow jika bikin white illusion */
        }
        /* Footer tetap tampil, background putih dengan border top */
        .main-footer {
            margin-left: 0 !important;
            margin-right: 0 !important;
            width: 100% !important;
            flex-shrink: 0 !important;
            background-color: #ffffff !important; /* Putih, kontras dengan biru muda */
            border-top: 1px solid #dee2e6 !important; /* Border abu-abu tipis untuk pemisah */
            color: #6c757d !important; /* Teks abu-abu agar terbaca */
        }
        .main-footer strong {
            color: inherit !important;
        }
        /* Hide navbar untuk guest */
        .main-header {
            display: none !important;
        }
        /* Hilangkan white dari card login jika ada override */
        .login-box .card {
            background-color: white !important; /* Card tetap white untuk kontras */
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2) !important;
        }
         .main-sidebar {
        background-color: #ffffff !important;
        color: #333;
    }

    .main-sidebar .nav-link {
        color: #333 !important;
        font-weight: 500;
        border-radius: 8px;
        margin: 2px 8px;
        transition: 0.2s;
    }

    /* Hover effect */
    .main-sidebar .nav-link:hover {
        background-color: #e6f0ff !important;
        color: #007bff !important;
    }

    /* Active link — menu yang diklik */
    .main-sidebar .nav-item > .nav-link.active {
        background-color: #d9e8ff !important; /* biru muda */
        color: #007bff !important; /* teks biru */
        font-weight: 600;
        box-shadow: inset 0 0 0 1px #007bff33;
    }

    /* Warna ikon aktif */
    .main-sidebar .nav-item > .nav-link.active i {
        color: #007bff !important;
    }

    /* Branding header */
    .brand-link {
        background-color: #f8f9fa !important;
        border-bottom: 1px solid #e0e0e0;
        color: #007bff !important;
        font-weight: bold;
    }
    </style>
    @endguest
</head>
<body class="hold-transition sidebar-mini">
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
