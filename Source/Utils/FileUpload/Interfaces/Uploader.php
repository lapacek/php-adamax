<?php

namespace Adamax\Utils\FileUpload\Interfaces;

require_once __DIR__.'/Image.php';

interface Uploader {
	public function upload(Image $image);
}