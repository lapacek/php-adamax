<?php

require_once __DIR__.'/../../../Source/Configuration/Classes/Configuration.php';
require_once __DIR__.'/../../../Source/Configuration/Classes/DocumentRoot.php';
require_once __DIR__.'/../../../Source/FileParser/Classes/IniFileParser.php';

use Adamax\Configuration\Classes\Configuration;

class ConfigurationTest extends PHPUnit_Framework_TestCase {
	
	protected $configuration;
	
	protected function setUp() {	
		$mockIniParser = $this->getMock('Adamax\FileParser\Classes\IniParser');
		
		$templatePaths = '{DOCUMENT_ROOT}View/Layout/, ';
		$templatePaths .= '{DOCUMENT_ROOT}View/Page/, ';
		$templatePaths .= '{DOCUMENT_ROOT}View/Component/';
		
		$config = array('Config' => array(
						'ConfigPath' => 'Config/',
						'FrameworkPath' => 'Framework/',
						'ApplicationPath' => 'Application/',
						'UrlMapPath' => '',
						'UrlMapFileName' => 'UrlMap.ini',
						'ImageTargetsMap' => ''),
						'Application' => array(
								'TemplatePath' => $templatePaths,
								'ControllerPath' => 'Application/Controller/',
								'ModelPath' => 'Application/Model/'),
						'Session' => array(
								'SessionName' => 'ADAMAX',
								'SessionTime' => '3600'));
		$mockIniParser->expects($this->any())
					->method('parse')
					->will($this->returnValue($config));
		
		$mockFile = $this->getMockBuilder('Adamax\Utils\File\Classes\File')
							->disableOriginalConstructor()
							->getMock();
		$mockFile->expects($this->any())
				->method('getName')
				->will($this->returnValue('config.ini'));
		
		
		
		$documentRoot = $this->getMockBuilder('Adamax\Configuration\Classes\DocumentRoot')
							->disableOriginalConstructor()
							->getMock();
		$documentRoot->expects($this->any())
				->method('getValue')
				->will($this->returnValue(__DIR__.'/../../../../../'));
		
		$this->configuration = new Configuration($mockIniParser, $mockFile, $documentRoot);		
	}

	public function testGetConfigPath() {	
		$configPath = $this->configuration->getConfigPath();
		$this->assertEquals(__DIR__.'/../../../../../Config/', $configPath);
	}

	public function testGetFrameworkPath() {	
		$framework = $this->configuration->getFrameworkPath();
		$this->assertEquals(__DIR__.'/../../../../../Framework/', $framework);
	}

	public function testGetApplicationPath() {	
		$applicationPath = $this->configuration->getApplicationPath();
		$this->assertEquals(__DIR__.'/../../../../../Application/', $applicationPath);
	}

	public function testGetUrlMapPath() {	
		$urlMapPath = $this->configuration->getUrlMapPath();
		$expected = __DIR__.'/../../../../../Config/UrlMap.ini';
		$this->assertEquals($expected, $urlMapPath);
	}

	public function testGetUrlMapFileName() {	
		$urlMapFileName = $this->configuration->getUrlMapFileName();
		$this->assertEquals('UrlMap.ini', $urlMapFileName);
	}
	
	public function testGetTemplatePath() {
		$templatePath = $this->configuration->getTemplatePath();
		$expect = __DIR__.'/../../../../../View/Layout/, ';
		$expect .= __DIR__.'/../../../../../View/Page/, ';
		$expect .= __DIR__.'/../../../../../View/Component/';
		$this->assertEquals($expect, $templatePath);
	}
	
	public function testGetControllerPath() {
		$controllerPath = $this->configuration->getControllerPath();
		$this->assertEquals(__DIR__.'/../../../../../Application/Controller/', $controllerPath);
	}
	
	public function testGetModelPath() {
		$modelPath = $this->configuration->getModelPath();
		$this->assertEquals(__DIR__.'/../../../../../Application/Model/', $modelPath);
	}
	
	public function testGetImageTargetMap() {
		$imageTargetMap = $this->configuration->getImageTargetsMap();
		$this->assertEquals(__DIR__.'/../../../../../Config/ImageTargetsMap.ini', $imageTargetMap);
	}
}
