<?= $this->extend('layout/admin') ?>

<?= $this->section('admin_content') ?>

<div class="mb-10">
    <h1 class="text-3xl font-black text-slate-900 tracking-tight"><?= $title ?></h1>
    <p class="text-slate-500 font-medium">Pantau semua aktivitas transaksi yang terjadi di toko Anda.</p>
</div>

<div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Referensi / Tgl</th>
                    <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Produk</th>
                    <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Nominal</th>
                    <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                    <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($orders as $order): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-5">
                            <p class="font-bold text-slate-900">#<?= $order->order_ref ?></p>
                            <p class="text-[10px] text-slate-400 font-medium"><?= date('d M Y, H:i', strtotime($order->created_at)) ?></p>
                        </td>
                        <td class="p-5">
                            <span class="text-sm font-semibold text-slate-700"><?= $order->product_name ?></span>
                        </td>
                        <td class="p-5 font-black text-slate-900">Rp<?= number_format($order->total_price, 0, ',', '.') ?></td>
                        <td class="p-5">
                            <?php
                            $statusClass = $order->status == 'completed' ? 'bg-green-50 text-green-600' : ($order->status == 'cancelled' ? 'bg-red-50 text-red-600' : 'bg-orange-50 text-orange-600');
                            ?>
                            <span class="text-[9px] font-black <?= $statusClass ?> px-3 py-1 rounded-full uppercase tracking-widest">
                                <?= $order->status ?>
                            </span>
                        </td>
                        <td class="p-5">
                            <div class="flex items-center space-x-2">
                                <?php if ($order->status == 'pending'): ?>
                                    <a href="<?= base_url('admin/orders/status/' . $order->id . '/completed') ?>" class="p-2 text-green-600 hover:bg-green-50 rounded-xl transition-all" title="Tandai Selesai">
                                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                                    </a>
                                    <a href="<?= base_url('admin/orders/status/' . $order->id . '/cancelled') ?>" class="p-2 text-red-400 hover:bg-red-50 rounded-xl transition-all" title="Batalkan">
                                        <i data-lucide="x-circle" class="w-5 h-5"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 flex justify-center">
    <?= $pager->links('orders', 'bento_pager') ?>
</div>

<?= $this->endSection() ?>