<?php $this->layout('layout/layout', ['title' => $title]) ?>

<?php $this->start('main') ?>
<header class="section-heading">
  <h1 class="title">Lab</h1>
</header>

<?php foreach ($labs as $lab): ?>
  <?php $this->insert('include/lab-summary', ['lab' => $lab]) ?>
<?php endforeach ?>
<?php $this->stop() ?>
