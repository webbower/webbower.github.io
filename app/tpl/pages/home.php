<?php $this->layout('layout/layout', ['title' => $title]) ?>

<?php $this->start('main') ?>
  <!-- Blog Summaries -->
  <section class="feed blog-feed">
    <header class="section-heading">
      <h2 class="title">Blog</h2>
    </header>

    <?php foreach ($blogPosts as $post): ?>
      <?php $this->insert('include/post-summary', ['post' => $post]) ?>
    <?php endforeach ?>
  </section>

  <!-- Project Listings (Lab) -->
  <?php if (count($labs) > 0): ?>
    <section class="feed lab-feed">
      <header class="section-heading">
        <h2 class="title">Lab</h2>
      </header>

      <?php foreach ($labs as $lab): ?>
        <?php $this->insert('include/lab-summary', ['lab' => $lab]) ?>
      <?php endforeach ?>
    </section>
  <?php endif ?>
<?php $this->stop() ?>
