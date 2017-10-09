<? // http://www.tutorialspoint.com/rss/rss2.0-tag-syntax.htm ?>
<?= '<?xml version="1.0"?>' . "\n" ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title><?= $rss->title ?></title>
    <link><?= $rss->link ?></link>
    <atom:link href="<?= $rss->link ?>" rel="self" type="application/rss+xml" />
    <description><?= $this->e($rss->description) ?></description>
    <language><?= $rss->lang ?></language>
    <copyright><?= $this->e($rss->copyright) ?></copyright>

    <?php foreach ($rss->items as $item): ?>
      <?= $this->insert('include/rss-item', ['item' => $item]) ?>
    <?php endforeach ?>
  </channel>
</rss>