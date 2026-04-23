<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> — <?= $app_name ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-white font-['Inter'] min-h-screen flex flex-col p-6">
    <!-- Header Mobile -->
    <div class="mt-8 mb-12">
        <a href="<?= base_url('auth/login') ?>" class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center mb-8">
            <i data-lucide="chevron-left" class="text-slate-900 w-5 h-5"></i>
        </a>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Daftar Akun</h1>
        <p class="text-slate-500 font-medium">Buat akun untuk mulai membeli paket Azure secara otomatis.</p>
    </div>

    <!-- Form Section -->
    <form action="<?= base_url('auth/store') ?>" method="POST" class="space-y-6 flex-grow">
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
            <input type="text" name="name" required class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none font-semibold text-slate-900" placeholder="Masukkan nama Anda">
        </div>
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Username</label>
            <input type="text" name="username" required class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none font-semibold text-slate-900" placeholder="Pilih username unik">
        </div>
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Password</label>
            <input type="password" name="password" required class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none font-semibold text-slate-900" placeholder="Min. 6 Karakter">
        </div>

        <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-xl shadow-slate-200 hover:bg-[#0078d4] transition-all">
            Buat Akun Sekarang
        </button>
    </form>

    <!-- Footer Login Link -->
    <div class="mt-12 text-center pb-8">
        <p class="text-sm text-slate-500 font-medium">Sudah punya akun? <a href="<?= base_url('auth/login') ?>" class="text-[#0078d4] font-bold">Masuk di sini</a></p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>