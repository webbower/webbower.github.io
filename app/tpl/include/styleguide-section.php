<section class="sg-section">
  <header>
    <h2 class="sg-heading"><?= $this->e($title) ?> (<code><?= implode('</code> &amp; <code>', $files) ?></code>)</h2>
  </header>

  <?php $this->insert("styleguide/{$module}", isset($moduleData) && is_array($moduleData) ? $moduleData : []) ?>
</section>
