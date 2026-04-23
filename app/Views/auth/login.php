<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> — <?= $app_name ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="bg-slate-50 font-['Inter'] min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <div class="text-center mb-10">
            <div class="w-12 h-12 bg-[#0078d4] rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg shadow-blue-200">
                <div class="w-5 h-5 bg-white rounded-sm rotate-45"></div>
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Panel Kontrol</h1>
            <p class="text-slate-500 font-medium">Silakan masuk untuk mengelola toko Anda.</p>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl text-sm font-bold text-center">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/attempt') ?>" method="POST" class="bg-white p-8 rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/50 space-y-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Username</label>
                <input type="text" name="username" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="admin">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Password</label>
                <input type="password" name="password" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="••••••••">
            </div>
            <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-xl shadow-slate-200 hover:bg-[#0078d4] transition-all">
                Masuk Sekarang
            </button>
        </form>

        <p class="text-center mt-10 text-slate-400 text-xs font-bold uppercase tracking-widest">
            &copy; <?= date('Y') ?> <?= $app_name ?> Security System
        </p>
    </div>
</body>

</html>