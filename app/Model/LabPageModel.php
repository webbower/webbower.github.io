<?php

namespace Webbower\Model;

use \Slim\Slim;
use \Webbower\SimpleData\Model;

class LabPageModel extends MarkdownPageModel
{
  public function getUrl($absolute = false)
  {
    $app = Slim::getInstance();
    return ($absolute ? $app->request->getUrl() : '') . $app->urlFor('lab-page', [
      'slug'  => $this->slug,
    ]);
  }

  public function getGithubUrl()
  {
    $app = Slim::getInstance();
    $gh = $app->config('social.github');
    return "http://github.com/{$gh}/{$this->id}";
  }

  public function getTagPairs()
  {
    return $this->generateTagPairs('lab-tag');
  }
  
  public function getSlug()
  {
    return pathinfo($this->path, PATHINFO_FILENAME);
  }
  
  public function getCanonical()
  {
    return $this->getUrl(true);
  }
}