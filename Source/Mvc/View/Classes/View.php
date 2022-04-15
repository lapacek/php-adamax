<?php

namespace Adamax\Mvc\View\Classes;

require_once __DIR__.'/../Interfaces/View.php';
require_once __DIR__.'/../../../Utils/File/Classes/File.php';
require_once __DIR__.'/../../Template/Classes/TwigTemplate.php';

use Adamax\Utils\File\Classes\File as File;
use Adamax\Mvc\Template\Classes\TwigTemplate;

class View implements \Adamax\Mvc\View\Interfaces\View {
	
	private $configuration;
	private $data;
	private $file;
	private $template;
	
	public function __construct(File $file) {
		$this->file = $file;
		$this->template = new TwigTemplate($file->getContent());
	}
	
	public function display() {
		echo $this->render();
	}

	public function render() {
		return $this->template->render($this->file->getContent());
	}

	public function addComponent($name, \Adamax\Mvc\View\Interfaces\View $view) {
		$this->template->addComponent($name, $view);
	}

	public function setData($name, $value) {
		$this->template->setData($name, $value);
	}
}