<?php

namespace Adamax\Utils\FileUpload\Classes;

require_once __DIR__.'/../Interfaces/Target.php';

class Target implements \Adamax\Utils\FileUpload\Interfaces\Target {
	
	private $directory;
	private $height;
	private $name;
	private $width;

	public function __construct($name, $directory, $width, $height) {
		$this->name = $name;
		$this->directory = $directory;
		$this->width = $width;
		$this->height = $height;
	}

	public function getDirectory() {
		return $this->directory;
	}

	public function getHeight() {
		return $this->height;
	}

	public function getName() {
		return $this->name;
	}

	public function getWidth() {
		return $this->width;
	}
	
}