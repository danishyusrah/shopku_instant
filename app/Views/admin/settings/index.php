<?= $this->extend('layout/admin') ?>

<?= $this->section('admin_content') ?>

<div class="mb-10 text-slate-900">
    <h1 class="text-3xl font-black tracking-tight"><?= $title ?></h1>
    <p class="text-slate-500 font-medium">Ubah konten tampilan website Anda tanpa menyentuh kode.</p>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center space-x-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <span class="text-sm font-bold"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<form action="<?= base_url('admin/settings/update') ?>" method="POST" class="max-w-4xl grid md:grid-cols-2 gap-8 text-slate-900">
    <!-- Branding -->
    <div class="bg-white p-8 rounded-[2rem] border border-slate-200 shadow-sm space-y-6">
        <h3 class="font-black uppercase tracking-widest text-xs text-slate-400">Branding & Kontak</h3>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Website</label>
            <input type="text" name="site_name" value="<?= $settings->site_name ?>" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none font-bold">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tagline (Hero Badge)</label>
            <input type="text" name="site_tagline" value="<?= $settings->site_tagline ?>" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none font-bold">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">WhatsApp (Format: 628xxx)</label>
            <input type="text" name="whatsapp_number" value="<?= $settings->whatsapp_number ?>" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none font-bold">
        </div>
    </div>

    <!-- Hero Content -->
    <div class="bg-white p-8 rounded-[2rem] border border-slate-200 shadow-sm space-y-6">
        <h3 class="font-black uppercase tracking-widest text-xs text-slate-400">Konten Landing Page</h3>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Utama (Hero)</label>
            <input type="text" name="hero_title" value="<?= $settings->hero_title ?>" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none font-bold">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Hero</label>
            <textarea name="hero_description" rows="4" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none font-medium text-sm"><?= $settings->hero_description ?></textarea>
        </div>
    </div>

    <div class="md:col-span-2 flex justify-end">
        <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold shadow-xl shadow-slate-200 hover:bg-[#0078d4] transition-all">
            Simpan Konfigurasi
        </button>
    </div>
</form>

<?= $this->endSection() ?>