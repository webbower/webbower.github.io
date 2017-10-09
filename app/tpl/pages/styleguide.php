<?php $this->layout('layout/layout', ['title' => $title]) ?>

<?php $this->start('extraHead') ?>
  <link href="<?= $this->asset('/css/styleguide.css') ?>" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start('main') ?>
<header>
  <h1 class="page-heading">Styleguide</h1>
</header>

<?php $this->insert('include/styleguide-section', [
  'module' => 'typography',
  'title' => 'Typography',
  'files' => ['_typography.scss', '_links.scss']
]) ?>

<?php $this->insert('include/styleguide-section', [
  'module' => 'headings',
  'title' => 'Headings',
  'files' => ['_headings.scss']
]) ?>

<?php $this->insert('include/styleguide-section', [
  'module' => 'highlight-box',
  'title' => 'Highlight Box',
  'files' => ['_highlight-box.scss']
]) ?>

<?php $this->insert('include/styleguide-section', [
  'module' => 'lists',
  'title' => 'Lists',
  'files' => ['_lists.scss'],
  'moduleData' => $tagModuleData
]) ?>

<?php $this->insert('include/styleguide-section', [
  'module' => 'meta',
  'title' => 'Meta',
  'files' => ['_utilities.scss'],
  'moduleData' => $tagModuleData
]) ?>

<?php $this->stop() ?>
