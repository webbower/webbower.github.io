<ul class="tag-list <?= (isset($classes) ? $classes : '') ?>">
  <?php foreach ($tags as $tag => $url): ?>
    <li><a href="<?= $url ?>"><?= $tag ?></a></li>
  <?php endforeach ?>
</ul>
