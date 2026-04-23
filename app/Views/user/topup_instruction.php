<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="bg-slate-50 min-h-screen px-6 pt-16 pb-32">
    <div class="text-center mb-10">
        <h2 class="text-xl font-black text-slate-900 mb-2 tracking-tight uppercase">Instruksi Pembayaran</h2>
        <p class="text-xs text-slate-500 font-bold tracking-widest uppercase">ID Transaksi: #TP-<?= rand(1000, 9999) ?></p>
    </div>

    <!-- QRIS Card -->
    <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200 border border-slate-100 text-center mb-8">
        <div class="flex justify-center mb-6">
            <img src="<?= $qr_image ?>" alt="QRIS" class="w-56 h-56 rounded-xl border-4 border-slate-50 p-2">
        </div>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Transfer (Wajib Sama)</p>
        <h3 class="text-3xl font-black text-[#0078d4] mb-4">Rp<?= number_format($total, 0, ',', '.') ?></h3>
        <div class="p-3 bg-blue-50 rounded-xl inline-block text-[10px] font-bold text-blue-700">
            Termasuk Kode Unik: <b>Rp<?= substr($total, -3) ?></b>
        </div>
    </div>

    <!-- Step By Step -->
    <div class="space-y-4">
        <div class="flex items-center space-x-4 p-4 bg-white rounded-2xl shadow-sm border border-slate-100">
            <div class="w-8 h-8 bg-slate-900 text-white rounded-lg flex items-center justify-center font-bold text-xs">1</div>
            <p class="text-xs font-bold text-slate-600">Screenshot atau simpan Kode QR di atas.</p>
        </div>
        <div class="flex items-center space-x-4 p-4 bg-white rounded-2xl shadow-sm border border-slate-100">
            <div class="w-8 h-8 bg-slate-900 text-white rounded-lg flex items-center justify-center font-bold text-xs">2</div>
            <p class="text-xs font-bold text-slate-600">Buka aplikasi E-Wallet (DANA, OVO, GOPAY, dsb).</p>
        </div>
        <div class="flex items-center space-x-4 p-4 bg-white rounded-2xl shadow-sm border border-slate-100">
            <div class="w-8 h-8 bg-slate-900 text-white rounded-lg flex items-center justify-center font-bold text-xs">3</div>
            <p class="text-xs font-bold text-slate-600">Scan QR dan bayar nominal yang tertera.</p>
        </div>
    </div>

    <div class="mt-10 text-center">
        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-6">Sudah Bayar?</p>
        <a href="https://wa.me/628123456789?text=Konfirmasi%20Topup%20Rp<?= $total ?>" class="block w-full py-4 bg-green-500 text-white rounded-2xl font-bold shadow-lg shadow-green-100">
            Konfirmasi Via WhatsApp
        </a>
        <a href="<?= base_url('user/dashboard') ?>" class="block mt-4 text-xs font-bold text-slate-400">Kembali Ke Dashboard</a>
    </div>
</div>
<?= $this->endSection() ?>
