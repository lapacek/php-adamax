<?php

require_once __DIR__.'/../../../Source/Configuration/Classes/Configuration.php';
require_once __DIR__.'/../../../Source/Configuration/Classes/DocumentRoot.php';
require_once __DIR__.'/../../../Source/Core/Classes/Adamax.php';
require_once __DIR__.'/../../../Source/FileParser/Classes/IniFileParser.php';
require_once __DIR__.'/../../../Source/Utils/File/Classes/File.php';

use Adamax\Configuration\Classes\Configuration;
use Adamax\Configuration\Classes\DocumentRoot;
use Adamax\Core\Classes\Adamax;
use Adamax\FileParser\Classes\IniParser;
use Adamax\Utils\File\Classes\File;

class AdamaxTest extends PHPUnit_Framework_TestCase {

	protected $adamax;
	
	protected function setUp() {
		$parser = new IniParser();
		$file = new File(__DIR__.'/../Config/Configuration.ini');
		$documentRoot = new DocumentRoot(__DIR__.'/../');
		$configuration = new Configuration($parser, $file, $documentRoot);
		$this->adamax = new Adamax($configuration);
	}

	public function testRunSuccess() {
		$_GET['url'] = '/hello';
		$this->expectOutputString('Hello Test!');
		$this->adamax->run();
	}
}
