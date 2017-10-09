<!doctype html>
<!--[if lte IE 8]> <html lang="en" class="no-js oldie"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" class="no-js no-touch"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->e(isset($metaTitle) ? $metaTitle : $title) ?> :: <?= $this->e($siteName) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="alternate" type="application/rss+xml" title="Webbower Blog" href="<?= $rssUrl ?>" />

  <?php if (isset($metaDesc)): ?>
    <meta name="description" content="<?= $this->e($metaDesc) ?>">
  <?php endif ?>

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

  <?php if (isset($page) && $page->has('canonical')): ?>
    <link rel="canonical" href="<?= $page->canonical ?>" />
  <?php endif ?>

  <!-- <link href="//fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet"> -->
  <link href="<?= $this->asset('/css/main.css') ?>" rel="stylesheet">
  <!-- <link href="/css/syntax.css" rel="stylesheet"> -->
  <?= $this->section('extraHead') ?>
  <!--  <script src="js/vendor/modernizr-2.6.2.min.js"></script> -->
  <script>
  (function(docClasses) {
    docClasses.remove('no-js');
    docClasses.add('js');
  })(document.documentElement.classList);
  </script>
</head>
<body>
  <?php $this->insert('include/svg-sprites') ?>

  <header role="banner">
    <div class="inner">
      <h1><a href="<?= $homeUrl ?>"><?= $this->e($siteName) ?></a></h1>
      <p><?= $this->e($siteTagline) ?></p>

      <nav role="navigation" id="nav-primary">
        <ul>
        <?php foreach ($mainNav as $nav): ?>
          <li><?= $nav->isCurrent($request->getResourceUri()) ?></li>
        <?php endforeach ?>
        <?php foreach ($secondaryNav as $nav): ?>
          <li><?= $nav->isCurrent($request->getResourceUri()) ?></li>
        <?php endforeach ?>
        </ul>
      </nav>
    </div>
  </header>

  <main role="main">
    <div class="inner">
      <!--$content is for MD pages -->
      <?= isset($content) ? $content : $this->section('main') ?>
    </div>
  </main>

  <footer role="contentinfo">
    <div class="inner">
      <p class="copyright"><small>Copyright &copy; 2009&ndash;<?= getCurrentYear() ?> Matt Bower. All rights reserved.</small></p>

      <ul class="inline-list external-sites">
        <li><a href="http://github.com/<?= $githubUsername ?>" target="_blank"><svg class="icon" width="16" height="16"><use xlink:href="#icon-github"></use></svg></a></li>
        <li><a href="http://twitter.com/<?= $twitterUsername ?>" target="_blank"><svg class="icon" width="16" height="16"><use xlink:href="#icon-twitter"></use></svg></a></li>
      </ul>
    </div>
  </footer>

  <?= $this->section('extraFoot') ?>

  <?php if (isset($analyticsId)): ?>
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', '<?= $this->e($analyticsId) ?>']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
  <?php endif; ?>
  <?php /*
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <!--  <script>
    (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
    function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
    e=o.createElement(i);r=o.getElementsByTagName(i)[0];
    e.src='//www.google-analytics.com/analytics.js';
    r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
    ga('create','{{ site.ga-id }}');ga('send','pageview');
    </script>
    -->
    <!--
    <script>
    var _gaq=[['_setAccount','{{ site.ga-id }}'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src='//www.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>
    -->
  */ ?>
</body>
</html>
