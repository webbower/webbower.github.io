<?php

namespace Webbower\View;

/**
 * View
 */
class View extends \Slim\View
{
  /**
   * @var \League\Plates\Engine
   */
  protected $engine;

  public function __construct()
  {
    parent::__construct();
    $this->engine = new \League\Plates\Engine();
  }

  public function loadPlatesExtension(\League\Plates\Extension\ExtensionInterface $extension)
  {
    $this->engine->loadExtension($extension);
  }

  public function setTemplatesDirectory($directory)
  {
    parent::setTemplatesDirectory($directory);
    $this->engine->setDirectory(realpath(rtrim($directory, DIRECTORY_SEPARATOR)));
  }

  public function set($key, $value = null)
  {
    if (is_array($key)) $this->engine->addData($key);
    else $this->engine->addData([$key => $value]);
  }

  // public function attrs(array $attrs = [])
  // {
  //   $out = '';
  //   foreach ($attrs as $key => $value) {
  //     $out .= sprintf(
  //       ' %s="%s"',
  //       htmlspecialchars($key,   ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
  //       htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
  //     );
  //   }
  //   return $out;
  // }

  // Dislike manually calling echo
  public function fetchPage($page, array $data = null, $pageModel = 'MarkdownPageModel')
  {
    $app = \Slim\Slim::getInstance();
    $wrapperClass = "\\Webbower\\Model\\{$pageModel}";
    $page = $wrapperClass::fromFile($page);

    return $this->engine->render("page-md", array_merge(
      $this->data->all(),
      (array) $data,
      ['page' => $page]
    ));
  }

  public function renderPage($page, array $data = null, $pageModel = 'MarkdownPageModel')
  {
    echo $this->fetchPage($page, $data, $pageModel);
  }

  protected function render($template, $data = null)
  {
    if (!$this->engine->exists($template)) {
      throw new \RuntimeException("View cannot render `$template` because the template does not exist");
    }

    $data = array_merge($this->data->all(), (array) $data);
    return $this->engine->render($template, $data);
  }
}
