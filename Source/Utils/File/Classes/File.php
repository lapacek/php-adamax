<?php

namespace Adamax\Utils\File\Classes;

require_once __DIR__.'/../Interfaces/File.php';
require_once __DIR__.'/../../../Exception/Classes/FileNotExistsException.php';

use Adamax\Exception\Classes\FileNotExistsException;

class File implements \Adamax\Utils\File\Interfaces\File {
	
	private $name;
	
	public function __construct($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}

	public function getContent() {
		if ($this->isFileReadyToRead()) {
			return \file_get_contents($this->name);
		}
		throw new FileNotExistsException();
	}
	
	private function isFileReadyToRead() {
		return \file_exists($this->name) && \is_readable($this->name);
	}
}