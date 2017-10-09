<!DOCTYPE html>
<!--[if lte IE 8]> <html class="no-js oldie"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ page.title }} || {{ site.name }}</title>
	<meta name="description" content="{{ page.meta.desc }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

	<link href="//fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
	<link href="/css/main.css" rel="stylesheet">
	<link href="/css/syntax.css" rel="stylesheet">
<!--	<script src="js/vendor/modernizr-2.6.2.min.js"></script> -->
	<script>
	(function() {
		var docClasses = document.documentElement.classList;
		docClasses.remove('no-js');
		docClasses.add('js');
	})();
	</script>
</head>
<body id="{{ page.body.id }}" class="{{ page.body.class }}">
	<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->

	<!-- Add your site or application content here -->
	<header role="banner">
		{% include header.html %}
	</header>

	<main role="main">
		{{ content }}
	</main>

	<footer role="contentinfo">
		{% include footer.html %}
	</footer>

	<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<!--	<script>
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

</body>
</html>
