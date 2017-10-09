<?php $this->layout('layout/layout', ['title' => $page->title, 'page' => $page]) ?>

<?php $this->start('main') ?>
<header class="section-heading">
  <h1 class="title"><?= $page->title ?></h1>
</header>

  <!-- <?php if ($page->has('intro')): ?>
    <p class="intro"><?= $page->intro ?></p>
  <?php endif ?> -->

  <?= $page ?>
<?php $this->stop() ?>
