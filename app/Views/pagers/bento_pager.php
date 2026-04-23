<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation" class="flex items-center space-x-2">
    <?php if ($pager->hasPrevious()) : ?>
        <a href="<?= $pager->getFirst() ?>" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all" aria-label="<?= lang('Pager.first') ?>">
            «
        </a>
        <a href="<?= $pager->getPrevious() ?>" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all" aria-label="<?= lang('Pager.previous') ?>">
            ‹
        </a>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
        <a href="<?= $link['uri'] ?>" class="px-4 py-2 rounded-xl text-sm font-bold transition-all <?= $link['active'] ? 'bg-[#0078d4] text-white shadow-lg shadow-blue-200' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' ?>">
            <?= $link['title'] ?>
        </a>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
        <a href="<?= $pager->getNext() ?>" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all" aria-label="<?= lang('Pager.next') ?>">
            ›
        </a>
        <a href="<?= $pager->getLast() ?>" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all" aria-label="<?= lang('Pager.last') ?>">
            »
        </a>
    <?php endif ?>
</nav>