<?php $this->layout('layout/layout', ['title' => $title]) ?>

<?php $this->start('main') ?>
<header class="section-heading blog-heading">
  <h1 class="title">Blog</h1>
  <?php if (isset($filterTag)): ?>
    <p class="breadcrumb filter-tag">
      tag: <?= tagSlugToProperName($filterTag) ?>
      <a href="<?= $app->urlFor('blog-root') ?>" title="Clear tag filter" class="close">&times;</a>
    </p>
  <?php endif; ?>
  <!-- <aside>
    <a href="/rss" class="rss-link">RSS</a>
  </aside> -->
</header>

<?php foreach ($blogPosts as $post): ?>
  <?php $this->insert('include/post-summary', ['post' => $post]) ?>
<?php endforeach; ?>
<!-- <aside>
  <h2 class="title">Archives</h2>

  <h3>By Year</h3>

  <h3>By Month</h3>
</aside> -->
<?php $this->stop() ?>
