<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="bg-slate-50 min-h-screen pb-24">
    <!-- Header Profil (Mobile Friendly) -->
    <div class="bg-white px-6 pt-16 pb-8 rounded-b-[2.5rem] shadow-sm border-b border-slate-100">
        <div class="flex justify-between items-center mb-6">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Selamat Datang,</p>
                <h2 class="text-2xl font-black text-slate-900"><?= session()->get('name') ?></h2>
            </div>
            <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center">
                <i data-lucide="user" class="text-[#0078d4]"></i>
            </div>
        </div>

        <!-- Wallet Card -->
        <div class="bg-slate-900 rounded-[2rem] p-6 text-white relative overflow-hidden shadow-xl shadow-slate-200">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">Saldo Akun</p>
                <h3 class="text-3xl font-black mb-6">Rp<?= number_format(session()->get('balance') ?? 0, 0, ',', '.') ?></h3>
                <a href="<?= base_url('user/topup') ?>" class="inline-flex items-center space-x-2 bg-white text-slate-900 px-6 py-3 rounded-xl font-bold text-sm">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Isi Saldo</span>
                </a>
            </div>
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
        </div>
    </div>

    <!-- Active Accounts / Inventory -->
    <div class="px-6 mt-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-black text-slate-900 uppercase text-xs tracking-widest">Akun Azure Saya</h3>
            <span class="text-[10px] font-bold text-slate-400"><?= count($my_accounts) ?> Total</span>
        </div>

        <div class="space-y-4">
            <?php foreach ($my_accounts as $acc): ?>
                <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                                <i data-lucide="cloud" class="text-[#0078d4] w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-900 text-sm"><?= $acc->product_name ?></p>
                                <p class="text-[10px] text-slate-400 font-medium"><?= date('d M Y', strtotime($acc->created_at)) ?></p>
                            </div>
                        </div>
                        <button onclick="copyToClipboard('<?= $acc->credentials_delivered ?>')" class="p-2 bg-slate-50 rounded-lg">
                            <i data-lucide="copy" class="w-4 h-4 text-slate-400"></i>
                        </button>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <code class="text-[11px] font-mono text-slate-600 break-all"><?= $acc->credentials_delivered ?></code>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($my_accounts)): ?>
                <div class="text-center py-12 bg-white rounded-3xl border-2 border-dashed border-slate-100">
                    <i data-lucide="package" class="w-12 h-12 text-slate-200 mx-auto mb-4"></i>
                    <p class="text-sm text-slate-400 font-medium italic">Belum ada akun yang dibeli.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bottom Navigation (App Style) -->
    <div class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-xl border-t border-slate-100 px-8 py-4 flex justify-between items-center z-50">
        <a href="<?= base_url('user/dashboard') ?>" class="flex flex-col items-center text-[#0078d4]">
            <i data-lucide="home" class="w-6 h-6"></i>
            <span class="text-[9px] font-black uppercase mt-1">Beranda</span>
        </a>
        <a href="<?= base_url('history') ?>" class="flex flex-col items-center text-slate-400">
            <i data-lucide="shopping-bag" class="w-6 h-6"></i>
            <span class="text-[9px] font-black uppercase mt-1">Beli Akun</span>
        </a>
        <a href="<?= base_url('user/topup') ?>" class="flex flex-col items-center text-slate-400">
            <i data-lucide="wallet" class="w-6 h-6"></i>
            <span class="text-[9px] font-black uppercase mt-1">Saldo</span>
        </a>
        <a href="<?= base_url('auth/logout') ?>" class="flex flex-col items-center text-red-400">
            <i data-lucide="log-out" class="w-6 h-6"></i>
            <span class="text-[9px] font-black uppercase mt-1">Keluar</span>
        </a>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        const el = document.createElement('textarea');
        el.value = text;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        alert('Kredensial berhasil disalin!');
    }
</script>
<?= $this->endSection() ?>
