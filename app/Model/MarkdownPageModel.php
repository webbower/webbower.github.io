<?php

namespace Webbower\Model;

use \Slim\Slim;
use \Webbower\SimpleData\Model;

class MarkdownPageModel extends Model
{
  public static function fromFile($relativePath, $withContent = true)
  {
    $app = \Slim\Slim::getInstance();

    if ($withContent) {
      $data = $app->content->readData($relativePath);
      $meta = $data['meta'];
      $content = $app->markdownParser->convertToHtml($data['content']);
    }
    else {
      $meta = $app->content->readFrontMatter($relativePath);
      $content = '';
    }

    return new static(array_merge(
      $app->yamlParser->parse($meta),
      [
        'content' => $content,
        'path' => $relativePath,
      ]
    ));
  }

  public static function fromFileMetaOnly($relativePath)
  {
    return static::fromFile($relativePath, false);
  }
  
  public function __toString()
  {
    return $this->content;
  }

  protected function generateTagPairs($urlName)
  {
    if (!$this->tags) {
      return [];
    }
    
    $app = Slim::getInstance();
    
    $tags = [];
    foreach ($this->tags as $tag) {
      $slugged = slugify($tag);
      $tags[$tag] = $app->urlFor($urlName, ['tag' => $slugged]);
    }

    return $tags;
  }
}

// function MarkdownPageModel(array $meta = null, $content = null)
// {
//   return new MarkdownPageModel($meta, $content);
// }