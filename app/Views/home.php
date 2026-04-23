<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Hero -->
<section class="pt-48 pb-20 px-6">
    <div class="max-w-6xl mx-auto text-center">
        <div class="inline-flex items-center space-x-2 px-3 py-1 mb-6 bg-slate-100 rounded-full border border-slate-200">
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500"><?= $app_tagline ?? 'Premium Cloud' ?></span>
        </div>
        <h1 class="text-6xl md:text-8xl font-extrabold tracking-tighter leading-[0.9] mb-8 text-slate-900">
            Cloud <span class="text-[#0078d4]">Power.</span> Zero Friction.
        </h1>
        <p class="text-slate-500 text-lg md:text-xl max-w-xl mx-auto mb-12 font-medium">
            <?= $hero_description ?? 'Akses infrastruktur cloud terbaik sekarang juga.' ?>
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#pricing" class="bg-[#0078d4] text-white px-10 py-5 rounded-2xl font-bold text-lg shadow-2xl shadow-blue-200 hover:scale-105 transition-all">
                Lihat Katalog
            </a>
        </div>
    </div>
</section>

<!-- Pricing Grid (Bento Style) -->
<section id="pricing" class="py-20 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-3 gap-6">
            <?php foreach ($products as $product): ?>
                <div class="reveal bento-card p-8 flex flex-col <?= $product->is_recommended ? 'bg-slate-900 text-white border-none scale-105 shadow-2xl' : '' ?>">
                    <?php if ($product->is_recommended): ?>
                        <p class="text-[10px] font-black uppercase tracking-widest text-[#0078d4] mb-2">Recommended</p>
                    <?php else: ?>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2"><?= $product->category_name ?></p>
                    <?php endif; ?>

                    <h4 class="text-2xl font-bold mb-6 italic"><?= $product->name ?></h4>
                    <div class="flex items-baseline mb-8">
                        <span class="text-sm font-bold mr-1">IDR</span>
                        <span class="text-5xl font-black tracking-tighter"><?= number_format($product->price / 1000, 0) ?>k</span>
                    </div>

                    <div class="space-y-4 mb-10 flex-grow">
                        <?php
                        $features = json_decode($product->features, true) ?? [];
                        foreach ($features as $feature):
                        ?>
                            <div class="flex items-center text-sm font-medium <?= $product->is_recommended ? 'text-slate-300' : 'text-slate-600' ?>">
                                <i data-lucide="check" class="w-4 h-4 mr-3 text-[#0078d4]"></i>
                                <?= $feature ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- UPDATE: Form action diarahkan ke user/purchase -->
                    <form action="<?= base_url('user/purchase') ?>" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product->id ?>">
                        <button type="submit" class="w-full py-4 rounded-2xl font-bold transition-all <?= $product->is_recommended ? 'bg-[#0078d4] text-white hover:bg-white hover:text-slate-900' : 'border-2 border-slate-900 hover:bg-slate-900 hover:text-white' ?>">
                            Beli Sekarang
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>