<footer class="meta lab-meta">
  <ul class="inline-list">
    <li class="meta-item"><span class="label visuallyhidden">Current version:</span> <?= $lab->version ?></li>
    <li class="meta-item"><a href="<?= $lab->url ?>">Docs</a></li>
    <li class="meta-item"><a href="<?= $lab->githubUrl ?>">Source</a></li>
    <li>
      <?php $this->insert('modules/tag-list', ['tags' => $lab->tagPairs, 'classes' => 'meta-item']) ?>
    </li>
  </ul>
</footer>
