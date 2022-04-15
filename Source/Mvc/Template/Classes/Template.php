<?php

namespace Adamax\Mvc\Template\Classes;

require_once __DIR__.'/../../../Exception/Classes/FileNotExistsException.php';
require_once __DIR__.'/../../../Exception/Classes/UndefinedPropertyException.php';
require_once __DIR__.'/../Interfaces/Template.php';

use Adamax\Exception\Classes\FileNotExistsException;
use Adamax\Exception\Classes\UndefinedPropertyException;

class Template implements \Adamax\Mvc\Template\Interfaces\Template {
	
	private $content;
	private $data;
	
	public function __construct($fileName) {
		$this->loadContent($fileName);
		$this->data = array();
	}
	
	public function __set($name, $value) {
		$this->data[$name] = $value;
	}
	
	public function __get($name) {
		if (\array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}
		throw new UndefinedPropertyException('Undefined '. $name. ' property.');
	}
	
	public function render() {
	}
	
	private function loadContent($fileName) {
		if ($this->isFileNotReadyToRead($fileName)) {
			throw new FileNotExistsException('Template '. $fileName. ' was not found.');
		} 
		$this->content = \file_get_contents($fileName);
	}
	
	private function isFileNotReadyToRead($fileName) {
		return !(\file_exists($fileName) && \is_readable($fileName));
	}
	
	private function findAll() {
		
	}
}