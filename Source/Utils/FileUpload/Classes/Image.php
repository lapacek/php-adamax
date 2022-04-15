<?php

namespace Adamax\Utils\FileUpload\Classes;

require_once __DIR__.'/../Interfaces/Image.php';
require_once __DIR__.'/../Interfaces/Target.php';

class Image implements \Adamax\Utils\FileUpload\Interfaces\Image {
	private $inputName;
	private $name;
	private $type;
	private $tmpName;
	private $error;
	private $size;	
	private $created;
	private $hashName;
	private $targets;
	private $temporaryPath;

	public function __construct($inputName, $name, $type, $tmpName, $error, $size) {
		$this->inputName = $inputName;
		$this->name = $name;
		$this->type = $type;
		$this->tmpName = $tmpName;
		$this->error = $error;
		$this->size = $size;
		$this->initialize();
	}
	
	public function addTarget(\Adamax\Utils\FileUpload\Interfaces\Target $target) {
		$this->targets[] = $target;
	}

	public function createHashName() {
		$name = $this->name. $this->created. \date('now');
		return \md5($name). '.png';
	}
	
	public function getCreated() {
		return $this->created;
	}
	
	public function hasTemporaryPath() {
		return !\is_null($this->temporaryPath);
	}
	
	public function getError() {
		return $this->error;
	}
	
	public function getInputName() {
		return $this->inputName;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getHashName() {
		return $this->hashName;
	}
	
	public function getTmpName() {
		return $this->tmpName;
	}
	
	public function getTargets() {
		return $this->targets;
	}

	public function getTemporaryPath() {
		return $this->temporaryPath;		
	}
	
	public function setTemporaryPath($termporaryPath) {
		$this->temporaryPath = $termporaryPath;
	}
	
	private function initialize() {
		$dateTime = new \DateTime('NOW');
		$this->created = $dateTime->format('Y-m-d H:i:s');
		$this->hashName = $this->createHashName();
		$this->targets = array();
	}
}