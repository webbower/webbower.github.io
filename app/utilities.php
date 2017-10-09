<?php

function slugify($string)
{
  // lowercase
  // strip punctuation
  // whitespace -> hyphen
  return preg_replace('!\s+!', '-', strtolower($string));
}

function unslugify($string)
{
  return ucwords(preg_replace('!-!', ' ', $string));
}

function tagSlugToProperName($slug)
{
  $slugToTermMap = [
    'silverstripe' => 'SilverStripe',
    'php' => 'PHP',
    'cms' => 'CMS',
  ];

  if (array_key_exists($slug, $slugToTermMap)) {
    return $slugToTermMap[$slug];
  }
  else {
    return unslugify($slug);
  }
}

function getCurrentYear()
{
  return date('Y', time());
}

function rangeRegex($start, $end) {
  return '(?:' . implode(
    '|',
    array_map(
      function($m) {
        return str_pad($m, 2, '0', STR_PAD_LEFT);
      },
      range($start, $end)
    )
  ) . ')';
}
