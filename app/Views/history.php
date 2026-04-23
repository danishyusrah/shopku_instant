<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="pt-40 pb-20 px-6 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <div class="mb-12 text-center md:text-left">
            <h2 class="text-4xl font-black tracking-tighter text-slate-900 mb-2"><?= $title ?></h2>
            <p class="text-slate-500 font-medium">Katalog produk Azure Student yang tersedia saat ini.</p>
        </div>

        <div class="grid gap-4">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="reveal bento-card p-6 flex flex-col md:flex-row justify-between items-center gap-6">
                        <div class="flex items-center space-x-6 w-full md:w-auto">
                            <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="package" class="text-[#0078d4] w-6 h-6"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900"><?= $product->name ?></h4>
                                <p class="text-xs text-slate-400 font-medium uppercase tracking-widest">Stock: <?= $product->stock ?> Units</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-8 w-full md:w-auto justify-between md:justify-end">
                            <div class="text-right">
                                <p class="text-xs font-bold text-slate-400 uppercase">Harga</p>
                                <p class="font-black text-[#0078d4]">Rp<?= number_format($product->price, 0, ',', '.') ?></p>
                            </div>
                            <!-- UPDATE: Form action diarahkan ke user/purchase -->
                            <form action="<?= base_url('user/purchase') ?>" method="POST">
                                <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-[#0078d4] transition-all">
                                    Beli
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="p-20 text-center border-2 border-dashed border-slate-100 rounded-3xl">
                    <p class="text-slate-400 font-medium">Belum ada data produk tersedia.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-12 flex justify-center">
            <?= $pager->links('group1', 'bento_pager') ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>