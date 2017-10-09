<?php

namespace Webbower\Model;

use \Webbower\SimpleData\Model;

class RssFeed extends Model
{
  protected static $fields = [
    'title' => 'String',
    'link' => 'String',
    // 'description' => 'String',
    'lang' => 'String',
    'copyright' => 'String',
    'items' => 'Array',
  ];
}