<?php

require_once __DIR__.'/../../../../Source/Mvc/Controller/Classes/Controller.php';
require_once __DIR__.'/../../../../Source/Mvc/Response/Classes/HttpResponse.php';
require_once __DIR__.'/../../../../Source/Mvc/Response/Classes/RedirectResponse.php';
require_once __DIR__.'/../../../../Source/Mvc/Response/Classes/ViewResponse.php';
require_once __DIR__.'/../../../../Source/Mvc/View/Classes/View.php';

use Adamax\Mvc\Response\Classes\HttpResponse;
use Adamax\Mvc\Response\Classes\ViewResponse;
use Adamax\Mvc\Response\Classes\RedirectResponse;

class HttpResponseTest extends PHPUnit_Framework_TestCase {
	
	protected $controller;
	
	protected function setUp() {
		$view = $this->getMockBuilder('\Adamax\Mvc\View\Classes\View')
							->disableOriginalConstructor()
							->getMock();
		$view->expects($this->any())
						->method('render')
						->will($this->returnValue('Rendering success.'));
	
		$this->controller = $this->getMockBuilder('\Adamax\Mvc\Controller\Classes\Controller')
							->disableOriginalConstructor()
							->getMock();
		$this->controller->expects($this->any())
						->method('redirect')
						->will($this->returnValue('/Test/Url/Address'));
		$this->controller->expects($this->any())
						->method('getView')
						->will($this->returnValue($view));
	}
	
	public function testGetViewResponse() {
		$response = new ViewResponse($this->controller);
		$this->assertInstanceOf('\Adamax\Mvc\Response\Classes\ViewResponse', $response);
		$pattern = '/Rendering success./';		
		$this->expectOutputRegex($pattern);
		$response->execute();
	}
	
	public function testGetRedirectResponse() {		
		$mockRoute = $this->getMockBuilder('\Adamax\Mvc\UrlMapper\Classes\Route')
						->disableOriginalConstructor()
						->getMock();

		$response = new RedirectResponse($this->controller, $mockRoute);
		$this->assertInstanceOf('\Adamax\Mvc\Response\Classes\HttpResponse', $response);
	}
}