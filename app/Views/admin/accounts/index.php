<?= $this->extend('layout/admin') ?>

<?= $this->section('admin_content') ?>

<div class="flex justify-between items-end mb-8">
    <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight"><?= $title ?></h1>
        <p class="text-slate-500 font-medium">Kelola data akun mentah yang akan dikirim otomatis ke pembeli.</p>
    </div>
    <button onclick="toggleModal('modal-bulk')" class="bg-slate-900 text-white px-6 py-3 rounded-2xl font-bold text-sm flex items-center space-x-2 shadow-lg hover:bg-[#0078d4] transition-all">
        <i data-lucide="upload-cloud" class="w-4 h-4"></i>
        <span>Bulk Import Akun</span>
    </button>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center space-x-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <span class="text-sm font-bold"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<!-- Inventory Table -->
<div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Produk</th>
                    <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Kredensial (Email|Pass|Recovery)</th>
                    <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                    <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($accounts as $acc): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-5">
                            <span class="text-xs font-bold text-slate-900"><?= $acc->product_name ?></span>
                        </td>
                        <td class="p-5">
                            <code class="text-[11px] bg-slate-100 px-2 py-1 rounded font-mono text-slate-600"><?= $acc->credentials ?></code>
                        </td>
                        <td class="p-5">
                            <?php if ($acc->is_sold): ?>
                                <span class="text-[9px] font-black bg-slate-100 text-slate-400 px-2 py-1 rounded-full uppercase tracking-widest">Terjual</span>
                            <?php else: ?>
                                <span class="text-[9px] font-black bg-green-50 text-green-600 px-2 py-1 rounded-full uppercase tracking-widest">Tersedia</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-5">
                            <a href="<?= base_url('admin/accounts/delete/' . $acc->id) ?>" onclick="return confirm('Hapus data ini?')" class="text-red-400 hover:text-red-600">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($accounts)): ?>
                    <tr>
                        <td colspan="4" class="p-10 text-center text-slate-400 font-medium italic">Gudang akun masih kosong.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Bulk Import -->
<div id="modal-bulk" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-6 bg-slate-900/40 backdrop-blur-sm">
    <div class="bg-white w-full max-w-2xl rounded-[2rem] shadow-2xl overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex justify-between items-center text-slate-900">
            <h3 class="text-xl font-black italic">Bulk Import Akun Azure</h3>
            <button onclick="toggleModal('modal-bulk')" class="text-slate-400 hover:text-slate-900"><i data-lucide="x"></i></button>
        </div>
        <form action="<?= base_url('admin/accounts/bulk_store') ?>" method="POST" class="p-8 space-y-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Produk Azure</label>
                <select name="product_id" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none font-bold text-slate-900">
                    <?php foreach ($products as $p): ?>
                        <option value="<?= $p->id ?>"><?= $p->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">List Akun (Satu baris per akun)</label>
                <textarea name="account_list" rows="10" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none font-mono text-xs" placeholder="email1@gmail.com|pass1|recovery1&#10;email2@gmail.com|pass2|recovery2"></textarea>
                <p class="mt-2 text-[10px] text-slate-400 font-medium italic">*Sistem akan otomatis menghitung jumlah baris sebagai penambah stok produk.</p>
            </div>
            <button type="submit" class="w-full py-4 bg-[#0078d4] text-white rounded-2xl font-bold shadow-xl shadow-blue-100 hover:bg-slate-900 transition-all">
                Import & Update Stok
            </button>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        document.getElementById(id).classList.toggle('hidden');
    }
</script>

<?= $this->endSection() ?>