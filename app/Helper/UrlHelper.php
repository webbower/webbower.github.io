<?php

namespace Webbower\Helper;

class UrlHelper {
  public static function isSection($requestUrl, $sectionUrl) {
    return strpos($requestUrl, $sectionUrl) === 0;
  }
}