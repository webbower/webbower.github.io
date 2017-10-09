<?php

date_default_timezone_set('UTC');

require '../vendor/autoload.php';

// use \Exception;
use \Slim\Slim;
use \Webbower\Model\NavLink;
use \Webbower\Middleware\CharsetMiddleware;

define('APP_ROOT', dirname(__DIR__));

$env = require_once('../_env.php');
$isProduction = $env['env'] === 'production';

if (!$isProduction) {
  ini_set('display_errors', 1);
}

$app = new Slim([
  'mode' => $env['env'],
  'templates.path' => '../app/tpl',
  'slim.errors' => '../logs/slim.log',
  'log.enabled' => true,
  'view' => new \Webbower\View\View(),
  // General config settings
  'site.name'      => 'Webbower',
  'site.tagline'   => 'Where Matt Bower cultivates healthy DOM trees',
  'analyticsId'    => 'UA-18539289-1',
  'social.twitter' => 'webbower',
  'social.github'  => 'webbower',
  'content'        => '../content',
  'content.blog'   => '../content/blog',
  'content.lab'    => '../content/lab',
]);

$app->add(new CharsetMiddleware());

$app->configureMode('production', function () use ($app) {
  $app->config(array(
    'log.level' => \Slim\Log::WARN,
    'debug' => false,
  ));
  $app->view->set([
    'analyticsId' => $app->config('analyticsId'),
  ]);
});

$app->configureMode('development', function () use ($app) {
  $app->config(array(
    'log.level' => \Slim\Log::INFO,
    'debug' => true,
  ));
  // $app->view->set([
  // ]);
});

$app->setName('webbower');

// $app->view->loadPlatesExtension(new \League\Plates\Extension\Asset(__DIR__, true));
$app->view->loadPlatesExtension(new \League\Plates\Extension\Asset(__DIR__));

$app->container->singleton('content', function($c) {
  return new \Webbower\Helper\ContentReader($c['settings']['content']);
});

$app->container->singleton('yamlParser', function() {
  return new \Symfony\Component\Yaml\Parser();
});

$app->container->singleton('markdownParser', function() {
  return new \League\CommonMark\CommonMarkConverter();
});

$app->error(function (Exception $e) use ($app) {
  $app->render('500', [
    'title' => 'There was a Problem',
    'message' => $e->getMessage(),
  ]);
});

$app->notFound(function () use ($app) {
  $app->render('404', [
    'title' => 'Not Found'
  ]);
});

\Slim\Route::setDefaultConditions([
  'year'  => '(?:19|20)\d\d',
  'month' => rangeRegex(1, 12),
  'date'  => rangeRegex(1, 31),
  'slug'  => '[a-z][a-z0-9-]*',
  'tag'   => '[a-z][a-z0-9-]*',
]);

$app->get('/contact', function () use ($app) {
    $app->response->setStatus(410);
    // echo '<pre>';
    // print_r(func_get_args());
    // print_r($app->response);
    // die;
})
->name('contact');

// Homepage
$app->get('/', '\Webbower\Controller\MainController::home')
    ->name('home');

// About page
$app->get('/about', '\Webbower\Controller\MainController::about')
    ->name('about');

// Styleguide
$app->get('/styleguide', '\Webbower\Controller\MainController::styleguide')
    ->name('styleguide');

// Full site tag search
// $app->get('/tag/:tag', function($tag) use ($app) {})
//     ->name('all-tag');

// Blog home
$app->get('/blog/', '\Webbower\Controller\BlogController::blog')
    ->name('blog-root');

// Blog tag listing
$app->get('/blog/tag/:tag', '\Webbower\Controller\BlogController::tag')
    ->name('blog-tag');

// Shorthand to redirect to canonical blog post
$app->get('/blog/rss', '\Webbower\Controller\BlogController::rss')
    ->name('blog-rss');

// Shorthand to redirect to canonical blog post
$app->get('/blog/:slug', '\Webbower\Controller\BlogController::blogPostRedirect')
    ->name('blog-post-redirect');

// Blog list by year
$app->get('/blog/:year/', '\Webbower\Controller\BlogController::blogYear')
    ->name('blog-year');

// Blog list by year/month
$app->get('/blog/:year/:month/', '\Webbower\Controller\BlogController::blogYearMonth')
    ->name('blog-year-month');

// Blog list by year/month/date
$app->get('/blog/:year/:month/:date/', '\Webbower\Controller\BlogController::blogYearMonthDate')
    ->name('blog-year-month-date');

// Blog post
$app->get('/blog/:year/:month/:date/:slug', '\Webbower\Controller\BlogController::blogPost')
    ->name('blog-post');

// Lab root
$app->get('/lab/', '\Webbower\Controller\LabController::lab')
    ->name('lab-root');

// Lab tag listing
$app->get('/lab/tag/:tag', '\Webbower\Controller\LabController::tag')
    ->name('lab-tag');

// Lab project page
$app->get('/lab/:slug', '\Webbower\Controller\LabController::labPage')
    ->name('lab-page');

// Load in some global template variables
$app->view->set([
  'homeUrl' => $app->urlFor('home'),
  'rssUrl' => $app->urlFor('blog-rss'),
  'app' => $app,
  'request' => $app->request,
  'debug' => !$isProduction && in_array($app->request->get('debug'), ['true', '1'], true) ? true : false,
  'siteName' => $app->config('site.name'),
  'siteTagline' => $app->config('site.tagline'),
  'twitterUsername' => $app->config('social.twitter'),
  'githubUsername' => $app->config('social.github'),
  'mainNav' => [
    new NavLink([
      'label' => 'Blog',
      'url' => $app->urlFor('blog-root'),
      'type' => 'section',
    ]),
    // new NavLink([
    //   'label' => 'Lab',
    //   'url' => $app->urlFor('lab-root'),
    //   'type' => 'section',
    // ]),
  ],
  'secondaryNav' => [
    // new NavLink([
    //   'label' => 'Home',
    //   'url' => $app->urlFor('home'),
    //   'type' => 'page',
    // ]),
    new NavLink([
      'label' => 'About',
      'url' => $app->urlFor('about'),
      'type' => 'page',
    ]),
  ]
]);

$app->run();
