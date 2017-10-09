<?php

namespace Webbower\Model;

use \Slim\Slim;
use \Webbower\SimpleData\Model;

class BlogPageModel extends MarkdownPageModel
{
  protected $dateTime;
  
  public function getUrl($absolute = false)
  {
    $app = Slim::getInstance();
    return ($absolute ? $app->request->getUrl() : '') . $app->urlFor('blog-post', [
      'year'  => $this->year,
      'month' => $this->month,
      'date'  => $this->day,
      'slug'  => $this->slug,
    ]);
  }
  
  public function getTagPairs()
  {
    return $this->generateTagPairs('blog-tag');
  }
  
  public function getSlug()
  {
    return substr(pathinfo($this->path, PATHINFO_FILENAME), 11);
  }
  
  public function getCanonical()
  {
    return $this->getUrl(true);
  }
  
  public function dateFormat($format)
  {
    return $this->dateTime()->format($format);
  }
  
  public function getDateRfc3339()
  {
    return $this->dateFormat(\DATE_RFC3339);
  }
  
  public function getDateHuman()
  {
    return $this->dateFormat('F j, Y');
  }
  
  public function getYear()
  {
    return $this->dateFormat('Y');
  }
  
  public function getMonth()
  {
    return $this->dateFormat('m');
  }
  
  public function getDay()
  {
    return $this->dateFormat('d');
  }
  
  public function dateTime()
  {
    if (is_null($this->dateTime)) {
      $this->dateTime = new \DateTime($this->date);
    }
    
    return $this->dateTime;
  }
}