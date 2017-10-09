<?php

namespace Webbower\Model;

use \Webbower\SimpleData\Model;
use \Webbower\Model\BlogPageModel;
use \DateTime;

class RssItem extends Model
{
  protected static $fields = [
    'title' => 'String',
    'link' => 'String',
    'description' => 'String',
    'author' => 'String',
    'guid' => 'String',
    'pubDate' => 'DateTime',
  ];

  public function getRssPubDate()
  {
    return $this->pubDate->format(DateTime::RSS);
  }

  public static function fromBlogPost(BlogPageModel $post)
  {
    return new self([
      'title' => $post->title,
      'link' => $post->canonical,
      'description' => $post->content,
      'author' => 'matt@webbower.com',
      'guid' => $post->canonical,
      'pubDate' => $post->dateTime(),
    ]);
  }
}