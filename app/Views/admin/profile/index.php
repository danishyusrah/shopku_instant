<?= $this->extend('layout/admin') ?>

<?= $this->section('admin_content') ?>

<div class="mb-10">
    <h1 class="text-3xl font-black text-slate-900 tracking-tight"><?= $title ?></h1>
    <p class="text-slate-500 font-medium">Kelola kredensial akses dan informasi akun administrator Anda.</p>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center space-x-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <span class="text-sm font-bold"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<div class="max-w-2xl">
    <form action="<?= base_url('admin/profile/update') ?>" method="POST" class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap Admin</label>
                    <input type="text" name="name" value="<?= $user->name ?>" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all outline-none font-semibold">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Username Akses</label>
                    <input type="text" name="username" value="<?= $user->username ?>" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all outline-none font-semibold">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="Kosongkan jika tak diubah">
                </div>
            </div>

            <div class="p-4 bg-blue-50 rounded-2xl flex items-start space-x-3">
                <i data-lucide="info" class="text-blue-600 w-5 h-5 mt-0.5"></i>
                <p class="text-xs text-blue-700 leading-relaxed font-medium">
                    Perubahan password akan langsung berlaku pada sesi login berikutnya. Pastikan Anda mengingat kredensial baru Anda.
                </p>
            </div>
        </div>

        <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-xl shadow-slate-200 hover:bg-[#0078d4] transition-all">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>