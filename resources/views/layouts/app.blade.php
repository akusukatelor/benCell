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
    </style>
    @endguest
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar (hanya tampil jika sudah login) -->
    @auth
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </li>
        </ul>
    </nav>
    @endauth

    <!-- Sidebar (hanya tampil jika sudah login) -->
    @auth
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <span class="brand-text font-weight-light">BEN CELL</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('products.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Produk</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Kategori</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('transactions.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>Transaksi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('service-orders.index') }}" class="nav-link">
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
        <section class="content">
            @yield('content')
        </section>
    </div>

    <!-- Footer (selalu tampil, di bottom) -->
    <footer class="main-footer text-center">
        <strong>&copy; {{ date('Y') }} BEN CELL</strong>
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>