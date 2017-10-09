<?php

namespace Webbower\Helper;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Plugin\ListPaths;

/**
 * ContentReader
 * 
 * Utility class to read in full or partial contents of YAML/Markdown content files
 */
class ContentReader
{
  /**
   * @var string
   */
  protected $contentExtension = 'md';

  /**
   * @var League\Flysystem\Filesystem
   */
  protected $filesystem;
  
  public function __construct($path)
  {
    $this->filesystem = new Filesystem(new LocalAdapter($path));
    $this->filesystem->addPlugin(new ListPaths);
  }

  public function has($relativePath)
  {
    return $this->filesystem->has($this->withExt($relativePath));
  }

  // Reads in the whole file as YAML (meta) and Markdown (content)
  public function readData($relativePath)
  {
    // return $this->filesystem->read($this->withExt($relativePath));
    $stream = $this->getStream($relativePath);

    $content = '';

    $meta = $this->getFrontMatter($stream);
    
    while(($line = fgets($stream, 4096)) !== false) {
      $content .= $line;
    }
    
    return compact('meta', 'content');
  }

  public function readFrontMatter($relativePath)
  {
    return $this->getFrontMatter($this->getStream($relativePath));
  }

  /**
   * Get list of lab pages in alpha order
   */
  public function listLabPages($limit = null)
  {
    return $this->listContentFiles('lab', $limit);
  }

  /**
   * Get list of blog posts in reverse chronological order
   */
  public function listBlogPosts($limit = null)
  {
    return array_reverse($this->listContentFiles('blog', $limit));
  }

  public function findBlogPostBySlug($slug)
  {
    // Use array_reduce instead of array_filter becuase the latter preserves indices (stupidly)
    $posts = array_reduce($this->filesystem->listPaths('blog'), function($acc, $path) use ($slug) {
      if (strpos($path, $slug) !== false) {
        $acc[] = $path;
      }
      return $acc;
    }, []);
    
    // Be more specific
    if (count($posts) > 1) {
      throw new Exception("Too many possible blog posts with slug '{$slug}'");
    }
    // No match
    else if (count($posts) === 0) {
      return false;
    }
    // Huzzah!
    else {
      return $posts[0];
    }
  }
  
  //// Helper functions
  protected function listContentFiles($directory, $limit = null)
  {
    return array_slice($this->filesystem->listPaths($directory), 0, $limit);
  }
  
  protected function hasExt($path)
  {
    return strlen(pathinfo($path, PATHINFO_EXTENSION)) > 0;
  }
  
  // Make sure the path has a file extension
  protected function withExt($path)
  {
    if ($this->hasExt($path)) return $path;
    else return $path . (!!$this->contentExtension ? '.' : '') . $this->contentExtension;
  }

  protected function getStream($path)
  {
    return $this->filesystem->readStream($this->withExt($path));
  }

  // A function that runs through the front matter, returning it if present. Has the added bonus of
  // forwarding the stream pointer past the front matter
  protected function getFrontMatter($stream)
  {
    // Front matter is at the beginning so start from there
    if (!rewind($stream)) {
      // throw
    }
    
    $buffer = '';

    // If there's front matter detected on the first line (also eats the first line)...
    if (rtrim(fgets($stream, 4096)) === '---') {
      // ...loop reading line-by-line until you can't anymore...
      while(($line = fgets($stream, 4096)) !== false) {
        // ...if we haven't reached the second "---", add to buffer and continue.
        if (rtrim($line) !== '---') $buffer .= $line;
        // ...otherwise return the buffer.
        else return $buffer;
      }
    }

    // Return an empty array if no front matter is detected
    return $buffer;
  }
}