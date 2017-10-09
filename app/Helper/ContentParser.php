<?php

namespace Webbower\Helper;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as LocalAdapter;
use Symfony\Component\Yaml\Parser as YamlParser;
use League\CommonMark\CommonMarkConverter as MarkdownParser;
use Webbower\Model\MarkdownPageModel as PageModel;

/**
 * ContentParser
 * 
 * Parser for Markdown files with YAML front matter
 */
class ContentParser
{
  /**
   * @var string
   */
  protected $contentExtention = 'md';

  /**
   * @var League\Flysystem\Filesystem
   */
  protected $filesystem;

  /**
   * @var Symfony\Component\Yaml\Parser
   */
  protected $yamlParser;

  /**
   * @var League\CommonMark\CommonMarkConverter
   */
  protected $markdownParser;

  public function __construct($path)
  {
    $this->filesystem = new Filesystem(new LocalAdapter($path)));
    $this->yamlParser = new YamlParser();
    $this->markdownParser = new MarkdownParser();
  }
  
  public function parse($name)
  {
    $stream = $this->getStream($name);
    return new PageModel(
      $this->parseFrontMatter($stream),
      $this->parsePageContent($stream)
    );
  }

  public function parseFrontMatter($stream)
  {
    // Allow calling via filename
    if (is_string($stream)) {
      return $this->parseFrontMatter($this->getStream($stream));
    }

    // Front matter is at the beginning of the file. Rewind just in case this is called second
    rewind($stream);

    $buffer = '';

    // No front matter detected, short out
    if (rtrim(fgets($stream, 4096)) !== '---') {
      return [];
    }
    
    while(($line = fgets($stream, 4096)) !== false) {
      if (rtrim($line) !== '---') $buffer .= $line;
      else return $this->yamlParser->parse($buffer);
    }

    return [];
  }

  public function parsePageContent($stream)
  {
    // Allow calling via filename
    if (is_string($stream)) {
      return $this->parsePageContent($this->getStream($stream));
    }

    return '';
  }
  
  public static function exists($name)
  {
    return $filesystem->has($this->filename($name));
  }
  
  //// Helper functions
  protected function getStream($name)
  {
    return $this->filesystem->readStream($this->filename($name))['stream'];
  }
  
  protected function filename($name)
  {
    return $name . '.' . $this->contentExtension;
  }
}
