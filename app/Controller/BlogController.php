<?php

namespace Webbower\Controller;

use \Slim\Slim;
use \Webbower\Model\BlogPageModel;
use \Webbower\Model\RssFeed;

/**
 * BlogController
 *
 * Controller for blog section
 */
class BlogController
{
  public static function blog()
  {
    $app = Slim::getInstance();
    $posts = array_map(function($path) {
      return BlogPageModel::fromFile($path);
    }, $app->content->listBlogPosts());

    $app->render('blog-list', [
      'title' => 'Webbower Blog',
      'blogPosts' => $posts,
    ]);
  }

  public static function blogYear($year)
  {
    $app = Slim::getInstance();
    $filteredPosts = array_filter($app->content->listBlogPosts(), function($path) use ($year) {
      return strpos(basename($path), $year) === 0;
    });
    $posts = array_map(function($path) {
      return BlogPageModel::fromFile($path);
    }, $filteredPosts);

    $app->render('blog-list', [
      'title' => "Webbower Blog posts for {$year}",
      'blogPosts' => $posts,
    ]);
  }

  public static function blogYearMonth($year, $month)
  {
    $app = Slim::getInstance();
    $filteredPosts = array_filter($app->content->listBlogPosts(), function($path) use ($year, $month) {
      return strpos(basename($path), "{$year}-{$month}") === 0;
    });
    $posts = array_map(function($path) {
      return BlogPageModel::fromFile($path);
    }, $filteredPosts);

    $app->render('blog-list', [
      'title' => "Webbower Blog posts for {$year}-{$month}",
      'blogPosts' => $posts,
    ]);
  }

  public static function blogYearMonthDate($year, $month, $date)
  {
    $app = Slim::getInstance();
    $filteredPosts = array_filter($app->content->listBlogPosts(), function($path) use ($year, $month, $date) {
      return strpos(basename($path), "{$year}-{$month}-{$date}") === 0;
    });
    $posts = array_map(function($path) {
      return BlogPageModel::fromFile($path);
    }, $filteredPosts);

    $app->render('blog-list', [
      'title' => "Webbower Blog posts for {$year}-{$month}-{$date}",
      'blogPosts' => $posts,
    ]);
  }

  public static function blogPost($year, $month, $date, $slug)
  {
    Slim::getInstance()->view->renderPage("blog/{$year}-{$month}-{$date}-{$slug}", null, 'BlogPageModel');
  }

  public static function blogPostRedirect($slug)
  {
    $app = Slim::getInstance();
    try {
      $path = $app->content->findBlogPostBySlug($slug);
    } catch (\Exception $e) {
      $app->notFound();
    }

    if ($path === false) {
      $app->notFound();
    }

    $app->redirect(BlogPageModel::fromFile($path, false)->url, 301);
  }

  public static function tag($tag)
  {
    $app = Slim::getInstance();
    $posts = array_map('Webbower\Model\BlogPageModel::fromFileMetaOnly', $app->content->listBlogPosts());

    $taggedPosts = array_filter($posts, function($post) use ($tag) {
      return in_array($tag, array_map('slugify', $post->tags));
    });

    $app->render('blog-list', [
      'title' => "Blog posts with {$tag} tag",
      'blogPosts' => $taggedPosts,
      'filterTag' => $tag,
    ]);
  }

 public static function rss()
 {
   $app = Slim::getInstance();
   $latestPosts = array_map('Webbower\Model\BlogPageModel::fromFile', $app->content->listBlogPosts());
   $rss = new RssFeed([
     'title' => 'Webbower Blog',
     'link' => $app->request->getUrl() . $app->urlFor('blog-rss'),
     'description' => '',
     'lang' => 'en-us',
     'copyright' => sprintf('Copyright © 2009–%s Matt Bower', getCurrentYear()),
     'items' => array_map('Webbower\Model\RssItem::fromBlogPost', $latestPosts),
   ]);
   $app->response->headers->set('Content-Type', 'application/rss+xml');
   $app->render('layout/rss', ['rss' => $rss]);
 }
}
