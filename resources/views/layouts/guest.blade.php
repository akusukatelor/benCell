<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login - BenCell')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

    <style>
        /* ===== Background Animasi Gelombang ===== */
        body.login-mode {
            margin: 0;
            padding: 0;
            height: 100vh;
            width: 100vw;
            background: url('{{ asset("img/gelombang.svg") }}') repeat;
            background-size: cover;
            animation: rotate 6s infinite alternate linear;
            overflow-x: hidden;
            overflow-y: auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Animasi background */
        @keyframes rotate {
    100% {
        background-position: 15% 50%;
    }
}

        /* ===== Login Box ===== */
        .login-box {
            width: 100%;
            max-width: 380px;
            z-index: 10;
        }

        .login-box .card {
            background: #ffffff !important;
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
            padding: 20px;
            border: none;
        }

        /* Responsive fix */
        @media (max-width: 480px) {
            .login-box {
                max-width: 90%;
            }
        }
    </style>

    @yield('style')
</head>
<body class="login-mode">

    <!-- Login Content -->
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
