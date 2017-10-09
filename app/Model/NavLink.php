<?php

namespace Webbower\Model;

use \Webbower\SimpleData\Model;

class NavLink extends Model
{
  public function __construct(array $data) {
    if (!array_key_exists('className', $data)) {
      $data['className'] = '';
    }
    
    parent::__construct($data);
  }

  public function isCurrent($requestPath) {
    switch ($this->type) {
      case 'section':
        return $this->isSection($requestPath) ? $this->copy(['className' => 'current']) : $this;
        break;
      case 'page':
        return $this->isPage($requestPath) ? $this->copy(['className' => 'current']) : $this;
        break;
      default:
        throw new \Exception('Unknown NavLink type: ' . $this->type);
        break;
    }
  }

  public function isSection($requestPath) {
    return strpos($requestPath, $this->url) === 0;
  }

  public function isPage($requestPath) {
    return $this->url === $requestPath;
  }

  public function __toString() {
    return sprintf('<a href="%s"%s>%s</a>',
      $this->url,
      strlen($this->className) > 0 ? ' class="' . $this->className . '"' : '',
      $this->label
    );
  }
}