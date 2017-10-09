<footer class="meta highlight-box">
  <ul class="post-meta">
    <li class="meta-item"><time itemprop="dateCreated" datetime="<?= $post->dateRfc3339 ?>" pubdate><?= $post->dateHuman ?></time></li>
    <li class="meta-item">
      <?php $this->insert('modules/tag-list', ['tags' => $post->tagPairs]) ?>
    </li>
    <li class="meta-item"><a href="<?= $post->url ?>">Permalink</a></li>
  </ul>
</footer>
