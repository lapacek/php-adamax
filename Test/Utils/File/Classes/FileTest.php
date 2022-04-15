<?php

require_once __DIR__.'/../../../../Source/Utils/File/Classes/File.php';
require_once __DIR__.'/../../../../Source/Exception/Classes/FileNotExistsException.php';

use Adamax\Utils\File\Classes\File;

class FileTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @expectedException Adamax\Exception\Classes\FileNotExistsException
	 */
	public function testGetContentFailIfFileIsNotExists() {
		$file = new File('NotExistsFileName.html');
		$content = $file->getContent();
	}
}