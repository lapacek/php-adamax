<?php

namespace Adamax\Utils\FileUpload\Classes;

require_once __DIR__.'/../Interfaces/Uploader.php';
require_once __DIR__.'/Image.php';
require_once __DIR__.'/ImagickUploadProcess.php';

class ImageUploader implements \Adamax\Utils\FileUpload\Interfaces\Uploader {
	
	private $errors;
	private $success;
	
	public function __construct() {
		$this->initialize();
	}
	
	public function getErrors() {
		return $this->errors;
	}
	
	public function getSuccess() {
		return $this->success;
	}
	
	public function restart() {
		$this->initialize();
	}
	
	public function setError($key, Image $image) {
		$this->errors[$key] = $image;
	}
	
	public function setSuccess($key, Image $image) {
		$this->success[$key] = $image;
	}

	public function upload(\Adamax\Utils\FileUpload\Interfaces\Image $image) {
		foreach ($image->getTargets() as $target) {
			try {
				$uploadProcess = new ImagickUploadProcess($image, $target);
				$uploadProcess->execute();
				$this->setSuccess($image->getName(), $image);
			} catch (\ImagickException $e) {
				$this->setError($image->getName(), $image);
			}
		}
	}
	
	private function initialize() {
		$this->errors = array();
		$this->success = array();
	}
}