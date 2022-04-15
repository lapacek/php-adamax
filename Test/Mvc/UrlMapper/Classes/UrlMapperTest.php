<?php

require_once __DIR__.'/../../../../Source/Configuration/Classes/Configuration.php';
require_once __DIR__.'/../../../../Source/Exception/Classes/InvalidUrlMapException.php';
require_once __DIR__.'/../../../../Source/Exception/Classes/RouteNotFoundException.php';
require_once __DIR__.'/../../../../Source/FileParser/Classes/IniFileParser.php';
require_once __DIR__.'/../../../../Source/Mvc/UrlMapper/Classes/Mapper.php';

use Adamax\Mvc\UrlMapper\Classes\Mapper;

class MapperTest extends PHPUnit_Framework_TestCase {

	protected $mapper;
	protected $route;

	protected function setUp() {
		$mockConfiguration = $this->getMockBuilder('Adamax\Configuration\Classes\Configuration')
							->disableOriginalConstructor()
							->getMock();
		
		$mockIniParser = $this->getMock('Adamax\FileParser\Classes\IniParser');
		$map = array(
					'news' => array('module' => 'Public',
										'controller' => 'News',
										'action' => 'getArticleByID',
										'pattern' => '/article/(id)/(seo)'),
					'cars' => array('module' => 'Public',
										'controller' => 'Cars',
										'action' => 'getAllCars',
										'pattern' => '/(language)/cars'));
		$mockIniParser->expects($this->any())
					->method('parse')
					->will($this->returnValue($map));
		
		$this->mapper = new Mapper($mockConfiguration, $mockIniParser);
		$this->route = $this->mapper->getRoute('/news/89/We-know-winner');
	}

	public function testCreateAddressSuccess() {
		$params = array('id' => 89, 'seo' => 'We-know-winner');
		$address = $this->mapper->createAddress('Public', 'News', 'getArticleByID', $params);
		$this->assertEquals('/news/89/We-know-winner', $address);
	}
	
	public function testGetRouteSuccess() {
		$this->assertInstanceOf('\Adamax\Mvc\UrlMapper\Classes\Route', $this->route);
	}

	public function testRouteModuleAttributeSuccess() {
		$this->assertEquals('Public', $this->route->getModule());
	}

	public function testRouteControllerAttributeSuccess() {
		$this->assertEquals('News', $this->route->getController());
	}

	public function testRouteActionAttributeSuccess() {
		$this->assertEquals('getArticleByID', $this->route->getAction());
	}

	public function testRoutePatternAttributeSuccess() {
		$this->assertEquals('/news/(id)/(seo)', $this->route->getPattern());
	}

	public function testRouteParamsCountSuccess() {
		$this->assertCount(2, $this->route->getParams());
	}

	public function testRouteFirstParamSuccess() {
		$params = $this->route->getParams();
		$this->assertEquals('89', $params['id']);	
	}

	public function testRouteSecondParamSuccess() {
		$params = $this->route->getParams();
		$this->assertEquals('We-know-winner', $params['seo']);
	}
	
	/**
	 * @expectedException Adamax\Exception\Classes\InvalidUrlMapException
	 */
	public function testUrlMapperContructingThrowInvalidUrlMapExceptionIfExpectedRouteParamsIsMissing() {
		$mockConfiguration = $this->getMockBuilder('Adamax\Configuration\Classes\Configuration')
							->disableOriginalConstructor()
							->getMock();
		
		$mockIniParser = $this->getMock('Adamax\FileParser\Classes\IniParser');
		$map = array('news' => array('controller' => 'News',
										'action' => 'getArticleByID',
										'pattern' => '/news/(id)/(seo)'));
		$mockIniParser->expects($this->any())
					->method('parse')
					->will($this->returnValue($map));
		
		$this->mapper = new Mapper($mockConfiguration, $mockIniParser);
	}
	
	/**
	 * @expectedException Adamax\Exception\Classes\RouteNotFoundException
	 */
	public function testCreateAddressThrowRouteNotFoundExceptionIfRouteIsNotExists() {
		$params = array('id' => 89, 'seo' => 'We-know-winner');
		$this->mapper->createAddress('Public', 'Nevs', 'getArticleByID', $params);
	}
	
	/**
	 * @expectedException Adamax\Exception\Classes\RouteNotFoundException
	 */
	public function testGetRouteThrowRouteNotFoundExceptionIfRouteForAddressIsNotFound() {
		$this->mapper->getRoute('/newz/89/We-know-winner');
	}
	
	public function testGetRouteByURLWithLanguageParameter() {
		$route = $this->mapper->getRoute('/cz/cars');
		$this->assertInstanceOf('\Adamax\Mvc\UrlMapper\Classes\Route', $this->route);
	}
	
	public function testGetLanguageParameter() {
		$route = $this->mapper->getRoute('/cz/cars');
		$params = $route->getParams();
		$this->assertEquals('cz', $params['language']);	
	}
}
