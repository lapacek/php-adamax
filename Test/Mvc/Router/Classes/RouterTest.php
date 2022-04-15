<?php

require_once __DIR__.'/../../../../Source/Exception/Classes/RouteNotFoundException.php';
require_once __DIR__.'/../../../../Source/Mvc/Controller/Classes/ControllerFactory.php';
require_once __DIR__.'/../../../../Source/Mvc/Router/Classes/Router.php';
require_once __DIR__.'/../../../../Source/Mvc/UrlMapper/Classes/Route.php';
require_once __DIR__.'/../Mock/Response/Response.php';

use Adamax\Configuration\Classes\Configuration;
use Adamax\FileParser\Classes\IniParser;
use Adamax\Mvc\Controller\Classes\ControllerFactory;
use Adamax\Mvc\Router\Classes\Router;
use Adamax\Mvc\UrlMapper\Classes\Mapper;
use Response\RouterTestResponse;

class RouterTest extends PHPUnit_Framework_TestCase {

	protected $router;
	protected $mockAuthentication;
	protected $mockControllerFactory;
	protected $mockRequest;
	protected $mockSession;
	protected $mockUrlMapper;

	protected function setUp() {
		$mockRoute = $this->getMock('Adamax\Mvc\UrlMapper\Classes\Route');
		$mockRoute->expects($this->any())
				->method('getRoute')
				->will($this->returnValue('Public/News'));
		$mockRoute->expects($this->any())
				->method('getRouteAction')
				->will($this->returnValue('getArticleByID'));
		
		$mockRouteParams = array(
			'id' => '89',
			'seo' => 'We-know-winner'
		);
		$mockRoute->expects($this->any())
				->method('getParams')
				->will($this->returnValue($mockRouteParams));
		
		$this->mockUrlMapper = $this->getMockBuilder('Adamax\Mvc\UrlMapper\Classes\Mapper')
							->disableOriginalConstructor()
							->getMock();
		$this->mockUrlMapper->expects($this->any())
					->method('getRoute')
					->will($this->returnValue($mockRoute));

		$mockController = $this->getMockBuilder('\Adamax\Mvc\Controller\Classes\Controller')
					->disableOriginalConstructor()
					->getMock();
		$mockResponse = new RouterTestResponse($mockController);
		$mockController->expects($this->any())
				->method('run')
				->will($this->returnValue($mockResponse));
		
		$this->mockControllerFactory = $this->getMockBuilder('Adamax\Mvc\Controller\Classes\ControllerFactory')
							->disableOriginalConstructor()
							->getMock();
		$this->mockControllerFactory->expects($this->any())
					->method('createController')
					->will($this->returnValue($mockController));
		
		$this->router = new Router($this->mockUrlMapper, 
								$this->mockControllerFactory, 
								$this->mockAuthentication, 
								$this->mockRequest, 
								$this->mockSession);
	}
	
	public function testDispatchSuccess() {
		$this->expectOutputString('Hello Test!');
		$this->router->dispatch('/news/89/We-know-winner');
	}
}
