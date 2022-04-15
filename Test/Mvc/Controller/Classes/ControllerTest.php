<?php

require_once __DIR__.'/MockController/Test/MockController.php';
require_once __DIR__.'/../../../../Source/Configuration/Classes/Configuration.php';
require_once __DIR__.'/../../../../Source/Exception/Classes/ControllerNotFoundException.php';
require_once __DIR__.'/../../../../Source/Mvc/Controller/Classes/ControllerFactory.php';
require_once __DIR__.'/../../../../Source/Mvc/UrlMapper/Classes/Mapper.php';

use Adamax\Mvc\Controller\Classes\ControllerFactory;

class ControllerTest extends PHPUnit_Framework_TestCase {
	
	protected $mockConfiguration;
	protected $mockRoute;
	protected $mockMapper;

	protected function setUp() {
		$this->mockConfiguration = $this->getMockBuilder('Adamax\Configuration\Classes\Configuration')
								->disableOriginalConstructor()
								->getMock();
		$controllerPath = __DIR__.'/MockController/';
		$this->mockConfiguration->expects($this->any())
						->method('getControllerPath')
						->will($this->returnValue($controllerPath));
		
		$this->mockConfiguration->expects($this->any())
						->method('getControllerName')
						->will($this->returnValue('MockController'));
		$this->mockRoute = $this->getMock('Adamax\Mvc\UrlMapper\Classes\Route');
		
		$this->mockRoute->expects($this->any())
						->method('getParams')
						->will($this->returnValue(array()));
		
		$this->mockMapper = $this->getMockBuilder('Adamax\Mvc\UrlMapper\Classes\Mapper')
								->disableOriginalConstructor()
								->getMock();
	}

	public function testCreateControllerSuccess() {		
		$controllerFactory = new ControllerFactory($this->mockConfiguration, $this->mockMapper);
		$concreteController = $controllerFactory->createController('Test', 'MockController', $this->mockRoute);
		$this->assertInstanceOf('Controller\Test\MockController', $concreteController);
	}
	
	/**
	 * @expectedException \Adamax\Exception\Classes\ControllerNotFoundException
	 */
	public function testCreateControllerThrowControllerNotFoundExceptionIfFileNotExists() {
		$controllerFactory = new ControllerFactory($this->mockConfiguration, $this->mockMapper);
		$controllerFactory->createController('Test', 'MoackControler', $this->mockRoute);
	}
}