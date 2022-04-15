<?php

require_once __DIR__.'/../../../../Source/Utils/FileUpload/Classes/HttpImageUploader.php';
require_once __DIR__.'/../../../../Source/Utils/FileUpload/Classes/Image.php';
require_once __DIR__.'/../../../../Source/Utils/FileUpload/Interfaces/HttpUploader.php';

use \Adamax\Utils\FileUpload\Classes\Image;

class HttpImageUploaderTestClass extends \Adamax\Utils\FileUpload\Classes\HttpImageUploader {
	
	protected function moveImage(Image $image) {
		if (file_exists($image->getTmpName()))
			return \copy($image->getTmpName(), $image->getTemporaryPath());
		return FALSE;
	}
}