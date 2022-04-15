<?php

require_once __DIR__.'/../../../../Source/Mvc/Request/Classes/HttpRequest.php';

use Adamax\Mvc\Request\Classes\HttpRequest;

class HttpRequestTest extends PHPUnit_Framework_TestCase {
	
	protected $request;

	protected function setUp() {
		$mockRoute = $this->getMockBuilder('Adamax\Mvc\UrlMapper\Classes\Route')
				->disableOriginalConstructor()
				->getMock();		
		$params = array('language' => 'cz');
		$mockRoute->expects($this->any())
				->method('getParams')
				->will($this->returnValue($params));
		
		$this->request = new HttpRequest($mockRoute);
	}
	
	public function testGetInputFromPOST() {
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$_POST['name'] = 'Adamax';
		$result = $this->request->getInput('name');
		$this->assertEquals('Adamax', $result);
	}
	
	public function testGetInputFromGET() {
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$_GET['name'] = 'Adamax';
		$result = $this->request->getInput('name');
		$this->assertEquals('Adamax', $result);
	}
	
	public function testGetInputReturnNull() {
		unset($_SERVER['REQUEST_METHOD']);
		unset($_POST['name']);
		$result = $this->request->getInput('surname');
		$this->assertNull($result);
	}
	
	public function testGetParameter() {
		$parameter = $this->request->getParameter('language');
		$invalidParameter = $this->request->getParameter('id');
		$this->assertEquals('cz', $parameter);
		$this->assertNULL($invalidParameter);
	}
	
	public function testHasPOSTInput() {
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$_POST['name'] = 'Adamax';
		$this->assertTrue($this->request->hasPostInput('name'));
	}
	
	public function testHasGETInput() {
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$_GET['name'] = 'Adamax';
		$this->assertTrue($this->request->hasGetInput('name'));
	}
	
	public function testHasPOSTInputFalse() {
		$_POST['name'] = 'Adamax';
		$this->assertFalse($this->request->hasPostInput('nickName'));
	}
	
	public function testHasGETInputFalse() {
		$_GET['name'] = 'Adamax';
		$this->assertFalse($this->request->hasGetInput('nickName'));
	}
}
