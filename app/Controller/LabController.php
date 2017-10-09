<?php

namespace Webbower\Controller;

use \Slim\Slim;
use \Webbower\Model\LabPageModel;

/**
 * LabController
 * 
 * Controller for lab section
 */
class LabController
{
  public static function lab()
  {
    // echo "Lab Home";
    $app = Slim::getInstance();
    $labs = array_map(function($path) {
      return LabPageModel::fromFile($path);
    }, $app->content->listLabPages());
    
    $app->render('lab-list', [
      'title' => 'Lab',
      'labs' => $labs,
    ]);
  }

  public static function labPage($slug)
  {
    // echo "Lab project page for {$slug}";
    Slim::getInstance()->view->renderPage("lab/{$slug}", null, 'LabPageModel');
  }
  
  public function tag($tag)
  {
    $app = Slim::getInstance();
    $labs = array_map('Webbower\Model\LabPageModel::fromFileMetaOnly', $app->content->listLabPages());

    $taggedLabs = array_filter($labs, function($lab) use ($tag) {
      return in_array($tag, array_map('slugify', $lab->tags));
    });
    
    $app->render('lab-list', [
      'title' => "Lab project with {$tag} tag",
      'labs' => $taggedLabs,
    ]);
  }
}