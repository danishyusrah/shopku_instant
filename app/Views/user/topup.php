<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="bg-white min-h-screen px-6 pt-16 pb-32">
    <div class="mb-10">
        <h2 class="text-2xl font-black text-slate-900 mb-2">Isi Saldo</h2>
        <p class="text-sm text-slate-500 font-medium">Pilih atau masukkan nominal topup akun Anda.</p>
    </div>

    <form action="<?= base_url('user/topup/generate') ?>" method="POST" class="space-y-8">
        <!-- Preset Amounts -->
        <div class="grid grid-cols-2 gap-4">
            <?php $presets = [10000, 25000, 50000, 100000];
            foreach ($presets as $val): ?>
                <button type="button" onclick="setAmount(<?= $val ?>)" class="p-4 border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-600 hover:border-[#0078d4] hover:text-[#0078d4] transition-all">
                    Rp<?= number_format($val, 0, ',', '.') ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Custom Amount -->
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Nominal Lainnya</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-slate-400">Rp</span>
                <input type="number" name="amount" id="custom-amount" required min="10000" class="w-full p-4 pl-12 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none font-black text-slate-900" placeholder="0">
            </div>
        </div>

        <div class="p-4 bg-orange-50 rounded-2xl flex items-start space-x-3 border border-orange-100">
            <i data-lucide="info" class="text-orange-500 w-5 h-5 mt-0.5"></i>
            <p class="text-[11px] text-orange-700 leading-relaxed font-medium">
                Penting: Kami menggunakan kode unik 3 digit terakhir untuk verifikasi. Pastikan Anda mentransfer nominal yang <b>persis</b> sama dengan instruksi nanti.
            </p>
        </div>

        <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-xl shadow-slate-200 flex items-center justify-center space-x-2">
            <span>Konfirmasi Topup</span>
            <i data-lucide="chevron-right" class="w-5 h-5"></i>
        </button>
    </form>
</div>

<script>
    function setAmount(val) {
        document.getElementById('custom-amount').value = val;
    }
</script>
<?= $this->endSection() ?>