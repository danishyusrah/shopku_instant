<?= $this->extend('layout/admin') ?>

<?= $this->section('admin_content') ?>

<div class="mb-10">
    <h1 class="text-3xl font-black tracking-tight text-slate-900">Halo, <?= session()->get('name') ?></h1>
    <p class="text-slate-500 font-medium">Berikut adalah rangkuman performa toko Anda dalam 7 hari terakhir.</p>
</div>

<!-- Statistik Utama -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-blue-50 rounded-2xl text-blue-600">
                <i data-lucide="dollar-sign" class="w-6 h-6"></i>
            </div>
            <span class="text-[10px] font-black text-green-500 bg-green-50 px-2 py-1 rounded-full uppercase">Profit</span>
        </div>
        <p class="text-slate-500 text-sm font-bold mb-1">Pendapatan Selesai</p>
        <p class="text-3xl font-black text-slate-900">Rp<?= number_format($total_revenue, 0, ',', '.') ?></p>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-slate-100 rounded-2xl text-slate-600">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
            </div>
        </div>
        <p class="text-slate-500 text-sm font-bold mb-1">Total Pesanan</p>
        <p class="text-3xl font-black text-slate-900"><?= $total_orders ?></p>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-red-50 rounded-2xl text-red-600">
                <i data-lucide="alert-circle" class="w-6 h-6"></i>
            </div>
        </div>
        <p class="text-slate-500 text-sm font-bold mb-1">Peringatan Stok</p>
        <p class="text-3xl font-black text-slate-900"><?= count($low_stock) ?> <span class="text-sm font-medium text-slate-400">Menipis</span></p>
    </div>
</div>

<div class="grid md:grid-cols-3 gap-8">
    <!-- Grafik Penjualan (7 Hari) -->
    <div class="md:col-span-2 bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
        <div class="flex justify-between items-center mb-8">
            <h3 class="font-black text-slate-900 tracking-tight">Tren Penjualan</h3>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-400">
                <span class="w-3 h-3 bg-[#0078d4] rounded-full"></span>
                <span>7 Hari Terakhir</span>
            </div>
        </div>
        <canvas id="salesChart" height="120"></canvas>
    </div>

    <!-- Inventory Alerts -->
    <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
        <h3 class="font-black text-slate-900 tracking-tight mb-8">Analisis Stok</h3>
        <div class="space-y-4">
            <?php foreach ($low_stock as $product): ?>
                <div class="flex items-center justify-between p-4 bg-red-50 rounded-2xl border border-red-100">
                    <div class="flex items-center space-x-3">
                        <i data-lucide="package-x" class="text-red-500 w-5 h-5"></i>
                        <span class="text-sm font-bold text-red-900"><?= $product->name ?></span>
                    </div>
                    <span class="text-xs font-black text-red-600 uppercase">Sisa <?= $product->stock ?></span>
                </div>
            <?php endforeach; ?>
            <?php if (empty($low_stock)): ?>
                <div class="text-center py-10">
                    <i data-lucide="shield-check" class="w-12 h-12 text-green-200 mx-auto mb-4"></i>
                    <p class="text-sm text-slate-400 font-medium">Stok dalam kondisi aman.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_labels) ?>,
            datasets: [{
                label: 'Pendapatan (IDR)',
                data: <?= json_encode($chart_values) ?>,
                borderColor: '#0078d4',
                backgroundColor: 'rgba(0, 120, 212, 0.05)',
                borderWidth: 4,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#0078d4',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        },
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>