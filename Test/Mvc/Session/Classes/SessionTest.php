<?php

require_once __DIR__.'/../../../../Source/Configuration/Classes/Configuration.php';
require_once __DIR__.'/../../../../Source/Mvc/Session/Classes/HttpSession.php';

use Adamax\Configuration\Classes\Configuration;
use Adamax\Mvc\Session\Classes\HttpSession;

class HttpSessionTest extends PHPUnit_Framework_TestCase {
	
	protected function setUp() {
		$user = array(
					'id' => '1',
					'userName' => 'Adamax',
					'roles' => array('admin', 'user'));
		
		$_SESSION['userLogin'] = $user;
		
		$this->mockConfiguration = $this->getMockBuilder('Adamax\Configuration\Classes\Configuration')
								->disableOriginalConstructor()
								->getMock();
		$this->mockConfiguration->expects($this->any())
						->method('getSessionName')
						->will($this->returnValue('ADAMAX'));
		$this->mockConfiguration->expects($this->any())
						->method('getSessionTime')
						->will($this->returnValue('3600'));
		$this->mockConfiguration->expects($this->any())
						->method('getSessionStoragePath')
						->will($this->returnValue(__DIR__.'/../Runtime/Session/'));
		
	}
	
	public function testSetAttribute() {		
		$session = new HttpSession($this->mockConfiguration);		
		$section = $session->getSection('userLogin');
		$section->setAttribute('userId', '1');
		$session = \NULL;
	}
	
	public function testGetAttribute() {		
		$session = new HttpSession($this->mockConfiguration);
		$section = $session->getSection('userLogin');
		$userId = $section->getAttribute('id');
		$this->assertEquals('1', $userId);
	}
	
	public function testHasSectionTrue() {
		$session = \NULL;
		$session = new HttpSession($this->mockConfiguration);
		$section = $session->getSection('userLogin');
		$result = $session->hasSection('userLogin');
		$this->assertTrue($result);
	}
	
	public function testHasSectionFalse() {
		$session = \NULL;
		$session = new HttpSession($this->mockConfiguration);
		$result = $session->hasSection('userLogin');
		$this->assertFalse($result);
	}
}
