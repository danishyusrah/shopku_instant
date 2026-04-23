<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> — Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .sidebar-item:hover {
            background-color: #f1f5f9;
        }

        .sidebar-item.active {
            background-color: #e2e8f0;
            color: #0078d4;
        }
    </style>
</head>

<body class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col">
        <div class="p-6 flex items-center space-x-3">
            <div class="w-6 h-6 bg-[#0078d4] rounded-md"></div>
            <span class="font-extrabold tracking-tighter text-lg italic text-slate-900">ADMIN</span>
        </div>

        <nav class="flex-grow px-4 space-y-1">
            <a href="<?= base_url('admin/dashboard') ?>" class="sidebar-item flex items-center space-x-3 p-3 rounded-xl text-sm font-bold text-slate-600 <?= url_is('admin/dashboard') ? 'active' : '' ?>">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span>Ringkasan</span>
            </a>
            <a href="<?= base_url('admin/products') ?>" class="sidebar-item flex items-center space-x-3 p-3 rounded-xl text-sm font-bold text-slate-600 <?= url_is('admin/products*') ? 'active' : '' ?>">
                <i data-lucide="package" class="w-5 h-5"></i>
                <span>Katalog Produk</span>
            </a>
            <!-- Menu Baru -->
            <a href="<?= base_url('admin/accounts') ?>" class="sidebar-item flex items-center space-x-3 p-3 rounded-xl text-sm font-bold text-slate-600 <?= url_is('admin/accounts*') ? 'active' : '' ?>">
                <i data-lucide="database" class="w-5 h-5"></i>
                <span>Gudang Akun</span>
            </a>
            <a href="<?= base_url('admin/orders') ?>" class="sidebar-item flex items-center space-x-3 p-3 rounded-xl text-sm font-bold text-slate-600 <?= url_is('admin/orders*') ? 'active' : '' ?>">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                <span>Daftar Pesanan</span>
            </a>
            <div class="py-4">
                <div class="h-px bg-slate-100 w-full"></div>
            </div>
            <a href="<?= base_url('admin/settings') ?>" class="sidebar-item flex items-center space-x-3 p-3 rounded-xl text-sm font-bold text-slate-600 <?= url_is('admin/settings*') ? 'active' : '' ?>">
                <i data-lucide="settings" class="w-5 h-5"></i>
                <span>Konfigurasi Web</span>
            </a>
            <a href="<?= base_url('admin/profile') ?>" class="sidebar-item flex items-center space-x-3 p-3 rounded-xl text-sm font-bold text-slate-600 <?= url_is('admin/profile*') ? 'active' : '' ?>">
                <i data-lucide="shield-check" class="w-5 h-5"></i>
                <span>Keamanan Admin</span>
            </a>
        </nav>

        <div class="p-4 border-t border-slate-100">
            <a href="<?= base_url('/') ?>" class="flex items-center space-x-3 p-3 rounded-xl text-sm font-bold text-red-500 hover:bg-red-50">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span>Keluar Panel</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow">
        <header class="bg-white border-bottom border-slate-200 p-4 flex justify-between items-center md:hidden">
            <span class="font-black text-slate-900">AZUREVAULT</span>
            <button class="p-2"><i data-lucide="menu"></i></button>
        </header>

        <div class="p-8 max-w-7xl mx-auto">
            <?= $this->renderSection('admin_content') ?>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>