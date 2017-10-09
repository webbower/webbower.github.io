<?php

namespace Webbower\Helper;

/**
 * BlogHelper
 * 
 * Helper methods for the blog
 */
class BlogHelper
{
  // Returns the relative filepath if found, false if not
  public function findPostBySlug($slug)
  {
    $app = \Slim\Slim::getInstance();
    // $app->content->
  }
  
  public function postExists($year, $month, $date, $slug)
  {
    $app = \Slim\Slim::getInstance();
    $filename = implode('-', [$year, $month, $date, $slug]);
    
    return $app->content->has("blog/{$filename}");
  }
  
  public function listBlogPosts($limit = INF)
  {
    
  }
}