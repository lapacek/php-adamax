<?php

namespace Adamax\Utils\FileUpload\Classes;

require_once __DIR__.'/Image.php';
require_once __DIR__.'/Target.php';

class ImagickUploadProcess {
	private $image;
	private $target;
	private $imagick;
	
	public function __construct(Image $image, Target $target) {
		$this->image = $image;
		$this->target = $target;
		$this->initializeImagick();
	}
	
	public function execute() {
		$this->resize();
		$this->write();
	}
	
	private function initializeImagick() {
		$this->imagick = new \Imagick($this->image->getTemporaryPath());
	}
	
	private function resize() {
		$width = $this->target->getWidth();
		$height = $this->target->getHeight();
		
		if ((int) $width > (int) $height) {
			$this->imagick->thumbnailImage((int) $width, 0, FALSE);
			if ($this->imagick->getImageHeight() > (int) $height) {
				$this->imagick->thumbnailImage(0, (int) $height, FALSE);
			}
		} else if ((int) $width < (int) $height) {
			$this->imagick->thumbnailImage(0, (int) $height, FALSE);
			if ($this->imagick->getImageWidth() > (int) $width) {
				$this->imagick->thumbnailImage((int) $width, 0, FALSE);
			}
		} else {
			if ($this->imagick->getImageWidth() > (int) $width) {
				$this->imagick->thumbnailImage((int) $width, 0, FALSE);
			}
			if ($this->imagick->getImageHeight() > (int) $height) {
				$this->imagick->thumbnailImage(0, (int) $height, FALSE);
			}
		}
	}
	
	private function write() {
		$path = $this->target->getDirectory(). $this->image->getHashName();
		$this->imagick->writeImage($path);
	}
}