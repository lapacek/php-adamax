<?php

namespace Adamax\Mvc\Template\Classes;

require_once __DIR__.'/../Interfaces/Template.php';
require_once __DIR__.'/TwigFactory.php';

use Adamax\Mvc\Template\Classes\TwigFactory;

class TwigTemplate implements \Adamax\Mvc\Template\Interfaces\Template {
	
	private $components;
	private $data;
	private $twig;
	private $template;
	
	public function __construct($template) {
		$this->twig = TwigFactory::getTwig();
		$this->template = $template;
		$this->data = array();
	}
	
	public function addComponent($name, $component) {
		$this->components[$name] = $component;
	}
	
	public function setData($name, $value) {
		$this->data[$name] = $value;
	}
	
	public function render() {
		$template = $this->compose();
		return $this->twig->render($template, $this->data);
	}

	private function compose() {
		if (\preg_match_all('/{ Component \$([^}]+) }/', $this->template, $matches) > 0) {
			$result = $this->template;
			foreach ($matches[1] as $name) {
				$component = $this->components[$name];
				$subTemplate = $component->render();
				$pattern = '/{ Component \$('. $name. ') }/';
				$result = \preg_replace($pattern, $subTemplate, $result);
			}
			return $result;
		}
		return $this->template;
	}
}