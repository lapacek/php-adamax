<?php

namespace Adamax\Utils\FileUpload\Classes;

require_once __DIR__.'/../Interfaces/HttpUploader.php';
require_once __DIR__.'/Image.php';
require_once __DIR__.'/Target.php';

class HttpImageUploader implements \Adamax\Utils\FileUpload\Interfaces\HttpUploader {
	
	private $configuration;
	private $images;
	private $uploader;

	public function __construct(\Adamax\Configuration\Classes\Configuration $configuration, ImageUploader $uploader) {
		$this->uploader = $uploader;
		$this->configuration = $configuration;
		$this->initializeImages();
	}
	
	public function getErrors() {
		return $this->uploader->getErrors();
	}
	
	public function getSuccess() {
		return $this->uploader->getSuccess();
	}
	
	public function restart() {
		$this->uploader->restart();
		$this->initializeImages();
	}
	
	public function addImage(Image $image) {
		$this->images[] = $image;
	}
	
	public function setError($key, Image $result) {
		$this->uploader->setError($key, $result);
	}

	public function upload() {
		foreach ($this->images as $image) {
			if ($this->hasHttpError($image)) { 
				$this->setError($image->getName(), $image);
				continue;
			}
			$this->uploadProcess($image);
		}
	}
	
	private function initializeImages() {
		$this->images = array();
	}
	
	private function hasHttpError($image) {
		if ((int) $image->getError() != UPLOAD_ERR_OK) {
			return TRUE;
		}
		return FALSE;
	}
	
	private function uploadProcess($image) {
		$temporary = $this->createTemporaryImagePath($image);
		$image->setTemporaryPath($temporary);
		if ($this->moveImage($image)) {
			$this->uploader->upload($image);
			$this->unlinkImage($image);
		} else {
			$this->setError($image->getName(), $image);
		}		
	}
	
	private function createTemporaryImagePath(Image $image) {
		return $this->configuration->getTemporaryImageDirectory(). $image->getName();
	}
	
	protected function moveImage(Image $image) {
		if (is_uploaded_file($image->getTmpName()))
			return \move_uploaded_file($image->getTmpName(), $image->getTemporaryPath());
		return FALSE;
	}
	
	private function unlinkImage(Image $image) {
		if ($image->hasTemporaryPath()) {
			\unlink($image->getTemporaryPath());
		}
	}
}