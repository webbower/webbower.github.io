<article class="entry lab-entry highlight-box">
  <header>
    <h2 class="title"><a href="<?= $lab->url ?>"><?= $lab->title ?></a></h2>
  </header>

  <p><?= $lab->desc ?></p>

  <?php $this->insert('include/lab-meta', ['lab' => $lab]) ?>
</article>