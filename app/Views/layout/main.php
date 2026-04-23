<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $app_name ?? 'AzureVault' ?> — Premium Cloud Accounts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
        }

        .bento-card {
            background: #white;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .bento-card:hover {
            border-color: #0078d4;
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05);
        }

        .grain-bg::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.02;
            z-index: 9999;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="grain-bg">

    <!-- Navigation -->
    <nav class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[94%] max-w-5xl">
        <div class="bg-white/80 backdrop-blur-xl border border-slate-200/50 rounded-2xl px-6 py-3 flex justify-between items-center shadow-lg shadow-black/[0.03]">
            <div class="flex items-center space-x-2">
                <div class="w-6 h-6 bg-[#0078d4] rounded-md"></div>
                <span class="font-extrabold tracking-tighter text-lg uppercase"><?= $app_name ?? 'AzureVault' ?></span>
            </div>

            <div class="hidden md:flex space-x-8 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                <a href="<?= base_url() ?>#features" class="hover:text-[#0078d4]">Teknologi</a>
                <a href="<?= base_url() ?>#pricing" class="hover:text-[#0078d4]">Paket</a>
                <a href="<?= base_url('history') ?>" class="hover:text-[#0078d4]">Katalog</a>
            </div>

            <div class="flex items-center space-x-3">
                <?php if (session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url(session()->get('role') == 'admin' ? 'admin/dashboard' : 'user/dashboard') ?>" class="bg-slate-900 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-[#0078d4] transition-all">
                        Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('auth/login') ?>" class="text-slate-600 text-xs font-bold uppercase tracking-widest hover:text-[#0078d4]">Masuk</a>
                    <a href="<?= base_url('auth/register') ?>" class="bg-slate-900 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-[#0078d4] transition-all">
                        Daftar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Content Area -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Global Footer -->
    <footer class="py-20 px-6 border-t border-slate-100 mt-20">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8 text-center md:text-left">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">
                    &copy; <?= date('Y') ?> <?= $app_name ?? 'AzureVault' ?> Indonesia.
                </p>
            </div>
            <div class="flex space-x-6">
                <a href="#" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-[#0078d4]">Syarat & Ketentuan</a>
                <a href="#" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-[#0078d4]">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('active');
            });
        });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>

</html>