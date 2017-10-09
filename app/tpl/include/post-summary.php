<article class="entry blog-entry">
  <header>
    <h2 class="title"><a href="<?= $post->url ?>"><?= $post->title ?></a></h2>
  </header>

  <?php if ($post->has('intro')): ?>
    <p><?= $post->intro ?></p>
  <?php endif ?>

  <?php $this->insert('include/post-meta', ['post' => $post]) ?>
</article>
