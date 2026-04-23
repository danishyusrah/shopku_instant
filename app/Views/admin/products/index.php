<?= $this->extend('layout/admin') ?>

<?= $this->section('admin_content') ?>

<div class="flex justify-between items-end mb-8">
    <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight"><?= $title ?></h1>
        <p class="text-slate-500 font-medium">Tambah, edit, atau hapus katalog akun Azure Anda.</p>
    </div>
    <button onclick="openAddModal()" class="bg-[#0078d4] text-white px-6 py-3 rounded-2xl font-bold text-sm flex items-center space-x-2 shadow-lg shadow-blue-200 hover:scale-105 transition-all">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Produk Baru</span>
    </button>
</div>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center space-x-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <span class="text-sm font-bold"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl flex items-center space-x-3">
        <i data-lucide="alert-circle" class="w-5 h-5"></i>
        <span class="text-sm font-bold"><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- Table Section -->
<div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Produk</th>
                    <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Harga</th>
                    <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Stok</th>
                    <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                    <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($products as $product): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-5">
                            <p class="font-bold text-slate-900"><?= $product->name ?></p>
                            <p class="text-xs text-slate-400 font-medium italic"><?= $product->category_name ?></p>
                        </td>
                        <td class="p-5 font-black text-slate-700">Rp<?= number_format($product->price, 0, ',', '.') ?></td>
                        <td class="p-5">
                            <form action="<?= base_url('admin/products/update_quick') ?>" method="POST" class="flex items-center space-x-2">
                                <input type="hidden" name="id" value="<?= $product->id ?>">
                                <input type="number" name="stock" value="<?= $product->stock ?>" class="w-16 p-2 bg-slate-100 border-none rounded-lg text-xs font-bold text-center focus:ring-2 focus:ring-blue-500">
                                <button type="submit" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </td>
                        <td class="p-5">
                            <?php if ($product->is_recommended): ?>
                                <span class="text-[9px] font-black bg-blue-50 text-blue-600 px-2 py-1 rounded-full uppercase tracking-tighter">Recommended</span>
                            <?php else: ?>
                                <span class="text-[9px] font-black bg-slate-100 text-slate-500 px-2 py-1 rounded-full uppercase tracking-tighter">Standard</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-5">
                            <div class="flex items-center space-x-2">
                                <button
                                    onclick="openEditModal(<?= htmlspecialchars(json_encode($product)) ?>)"
                                    class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                                </button>
                                <a href="<?= base_url('admin/products/delete/' . $product->id) ?>" onclick="return confirm('Hapus produk ini?')" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Product (Dynamic for Add/Edit) -->
<div id="modal-product" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-6 bg-slate-900/40 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex justify-between items-center text-slate-900">
            <h3 id="modal-title" class="text-xl font-black">Tambah Produk Baru</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-900 transition-colors">
                <i data-lucide="x"></i>
            </button>
        </div>
        <form id="form-product" action="<?= base_url('admin/products/store') ?>" method="POST" class="p-8 space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Akun / Paket</label>
                    <input type="text" name="name" id="field-name" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="Contoh: Azure Student $100 Professional">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Harga (IDR)</label>
                    <input type="number" name="price" id="field-price" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="75000">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Stok Awal</label>
                    <input type="number" name="stock" id="field-stock" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="10">
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Fitur (Pisahkan dengan koma)</label>
                    <textarea name="features" id="field-features" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all outline-none text-sm" rows="3" placeholder="Ganti Baru, Full Garansi, Deployment Guide"></textarea>
                </div>
                <div class="col-span-2 flex items-center space-x-3">
                    <input type="checkbox" name="is_recommended" id="is_recommended" value="1" class="w-5 h-5 border-slate-300 rounded text-blue-600 focus:ring-blue-500">
                    <label for="is_recommended" class="text-sm font-bold text-slate-700">Tandai sebagai Rekomendasi (Best Seller)</label>
                </div>
            </div>
            <button type="submit" id="btn-submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-xl shadow-slate-200 hover:bg-[#0078d4] transition-all">
                Simpan Katalog
            </button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('modal-product');
    const form = document.getElementById('form-product');
    const modalTitle = document.getElementById('modal-title');
    const btnSubmit = document.getElementById('btn-submit');

    function openAddModal() {
        modalTitle.innerText = "Tambah Produk Baru";
        btnSubmit.innerText = "Simpan Katalog";
        form.action = "<?= base_url('admin/products/store') ?>";
        form.reset();
        modal.classList.remove('hidden');
    }

    function openEditModal(product) {
        modalTitle.innerText = "Edit Produk";
        btnSubmit.innerText = "Update Katalog";
        form.action = "<?= base_url('admin/products/update/') ?>/" + product.id;

        document.getElementById('field-name').value = product.name;
        document.getElementById('field-price').value = product.price;
        document.getElementById('field-stock').value = product.stock;

        // Memproses JSON features kembali ke string koma
        const features = JSON.parse(product.features);
        document.getElementById('field-features').value = features.join(', ');

        document.getElementById('is_recommended').checked = product.is_recommended == 1;

        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target == modal) closeModal();
    }
</script>

<?= $this->endSection() ?>