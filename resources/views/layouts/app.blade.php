{{-- Layout utama aplikasi KasirKu. Halaman lain memakai @extends('layouts.app') --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') &middot; {{ config('app.name', 'KasirKu') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    :root {
        --bg-blue:    #EAF2FA;   /* background halaman */
        --soft-blue:  #B8D4F0;   /* aksen lembut */
        --mid-blue:   #6BA3D6;   /* biru sedang */
        --navy:       #1B3A5C;   /* navbar & teks */
        --navy-dark:  #0F2438;   /* judul & hover */
    }

    body {
        background: var(--bg-blue);
        color: var(--navy);
    }

    .navbar.bg-primary {
        background: var(--navy) !important;
        box-shadow: 0 2px 8px rgba(15, 36, 56, .15);
    }
    .navbar-brand {
        font-weight: 700;
        letter-spacing: .5px;
        color: #fff !important;
    }
    .navbar-dark .navbar-nav .nav-link {
        color: var(--soft-blue);
        font-weight: 500;
        border-radius: 6px;
        padding: 6px 14px;
        transition: all .2s;
    }
    .navbar-dark .navbar-nav .nav-link:hover {
        background: rgba(184, 212, 240, .15);
        color: #fff;
    }
    .navbar-dark .navbar-nav .nav-link.active {
        background: var(--soft-blue);
        color: var(--navy-dark);
        font-weight: 600;
    }

    .card {
        border: 0;
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 2px 10px rgba(27, 58, 92, .08);
    }
    .card-header {
        background: var(--navy);
        color: #fff;
        font-weight: 600;
        border-bottom: 0;
        border-radius: 10px 10px 0 0 !important;
    }

    .table {
        color: var(--navy);
    }
    .table thead {
        background: var(--navy);
        color: #fff;
    }
    .table thead th {
        white-space: nowrap;
        border-bottom: 0;
        font-weight: 600;
    }
    .table tbody tr:hover {
        background: #F2F8FD;
    }
    .harga {
        font-variant-numeric: tabular-nums;
        font-weight: 600;
        color: var(--navy-dark);
    }

    .stok {
        font-weight: 600;
        color: var(--navy);
        text-align: center;
    }
    .stok-badge {
        display: inline-block;
        min-width: 42px;
        padding: 4px 10px;
        background: var(--soft-blue);
        color: var(--navy-dark);
        border-radius: 999px;
        font-weight: 600;
        font-variant-numeric: tabular-nums;
    }
    .stok-badge.habis {
        background: #F5B7B1;
        color: #7B241C;
    }

    .aksi {
        white-space: nowrap;
        text-align: center;
    }
    .aksi .btn {
        padding: 4px 12px;
        font-size: .85rem;
        border-radius: 6px;
        margin: 0 2px;
        font-weight: 500;
    }

    .btn-primary {
        background: var(--navy);
        border-color: var(--navy);
        color: #fff;
    }
    .btn-primary:hover,
    .btn-primary:focus {
        background: var(--navy-dark);
        border-color: var(--navy-dark);
        color: #fff;
    }

    .btn-success {
        background: var(--mid-blue);
        border-color: var(--mid-blue);
        color: #fff;
    }
    .btn-success:hover {
        background: var(--navy);
        border-color: var(--navy);
        color: #fff;
    }

    .btn-warning {
        background: var(--soft-blue);
        border-color: var(--mid-blue);
        color: var(--navy-dark);
    }
    .btn-warning:hover {
        background: var(--mid-blue);
        border-color: var(--mid-blue);
        color: #fff;
    }

    .btn-danger {
        background: #F5B7B1;
        border-color: #E6B0AA;
        color: #7B241C;
    }
    .btn-danger:hover {
        background: #E74C3C;
        border-color: #E74C3C;
        color: #fff;
    }

    .btn-outline-secondary {
        color: var(--navy);
        border-color: var(--navy);
    }
    .btn-outline-secondary:hover {
        background: var(--navy);
        color: #fff;
    }

    .alert-success {
        background: #D6EAF8;
        color: var(--navy-dark);
        border-left: 4px solid var(--mid-blue);
    }
    .alert-danger {
        background: #FADBD8;
        color: #7B241C;
        border-left: 4px solid #E74C3C;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--mid-blue);
        box-shadow: 0 0 0 .2rem rgba(107, 163, 214, .3);
    }

    .badge.bg-success { background: var(--mid-blue) !important; color: #fff; }
    .badge.bg-danger  { background: #E74C3C !important; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">&#128179; KasirKu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home', 'produk.*') ? 'active' : '' }}"
                       href="{{ route('produk.index') }}">Daftar Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('transaksi.create') ? 'active' : '' }}"
                       href="{{ route('transaksi.create') }}">Transaksi Baru</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('transaksi.index', 'transaksi.show') ? 'active' : '' }}"
                       href="{{ route('transaksi.index') }}">Riwayat Transaksi</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container pb-5">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
