<?php if ($pager->getPageCount() > 1): ?>
<nav aria-label="Pagination">
  <ul class="pagination justify-content-center">
    <!-- Previous -->
    <li class="page-item <?= $pager->hasPrevious() ? '' : 'disabled' ?>">
      <?php if ($pager->hasPrevious()): ?>
        <a class="page-link" href="<?= $pager->getPrevious() ?>" aria-label="Previous">&laquo;</a>
      <?php else: ?>
        <span class="page-link">&laquo;</span>
      <?php endif; ?>
    </li>

    <!-- Page Numbers -->
    <?php foreach ($pager->links() as $link): ?>
      <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
        <?php if ($link['active']): ?>
          <span class="page-link"><?= $link['title'] ?></span>
        <?php else: ?>
          <a href="<?= $link['uri'] ?>" class="page-link"><?= $link['title'] ?></a>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>

    <!-- Next -->
    <li class="page-item <?= $pager->hasNext() ? '' : 'disabled' ?>">
      <?php if ($pager->hasNext()): ?>
        <a class="page-link" href="<?= $pager->getNext() ?>" aria-label="Next">&raquo;</a>
      <?php else: ?>
        <span class="page-link">&raquo;</span>
      <?php endif; ?>
    </li>
  </ul>
</nav>
<?php endif; ?>
