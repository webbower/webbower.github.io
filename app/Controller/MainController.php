<?php

namespace Webbower\Controller;

use \Slim\Slim;
use \Webbower\Model\BlogPageModel;
use \Webbower\Model\LabPageModel;

/**
 * MainController
 * 
 * Controller for generic, top-level pages
 */
class MainController
{
  public static function home()
  {
    $app = Slim::getInstance();
    $posts = array_map('Webbower\Model\BlogPageModel::fromFileMetaOnly', $app->content->listBlogPosts(5));
    
    // $labs = array_map('Webbower\Model\LabPageModel::fromFile', $app->content->listLabPages());
    $labs = [];

    // echo '<pre>';
    // print_r($posts);
    // print_r($labs);
    // die;
    
    $app->render('pages/home', [
      'metaTitle' => 'Webbower',
      'title' => 'Welcome',
      'blogPosts' => $posts,
      'labs' => $labs,
    ]);
  }

  public static function about()
  {
    Slim::getInstance()->view->renderPage('about');
  }

  public static function styleguide()
  {
    $tags = [
      'PHP' => '#',
      'JS' => '#',
      'Libraries' => '#',
      'Git' => '#',
    ];

    Slim::getInstance()->render('pages/styleguide', [
      'title' => 'Webbower Styleguide',
      'tagModuleData' => [
        'tags' => $tags
      ],
    ]);
  }
}