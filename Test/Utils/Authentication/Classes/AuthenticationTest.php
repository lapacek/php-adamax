<?php

require_once __DIR__.'/../../../../Source/Mvc/Session/Classes/HttpSession.php';
require_once __DIR__.'/../../../../Source/Utils/Authentication/Classes/Authentication.php';

use Adamax\Mvc\Session\Classes\HttpSession;
use Adamax\Utils\Authentication\Classes\Authentication;

class AuthenticationTest extends PHPUnit_Framework_TestCase {
	
	protected $authentication;
	protected $mockCongiguration;
	protected $mockSession;

	protected function setUp() {
		$user = array(
					'id' => '1',
					'userName' => 'Adamax',
					'roles' => array('admin', 'user'));
		
		$_SESSION['user-login'] = $user;
		$this->mockSession = $this->getMockBuilder('Adamax\Mvc\Session\Classes\HttpSession')
										->disableOriginalConstructor()
										->getMock();
		
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
		
		$session = new HttpSession($this->mockConfiguration);		
		$this->authentication = new Authentication($session);
	}
	
	public function testIsLoggedTrue() {
		$this->assertTrue($this->authentication->isLogged());
	}
	
	public function testGetUserIdSuccess() {
		$this->assertEquals('1', $this->authentication->getUserId());
	}
	
	public function testGetUserName() {
		$this->assertEquals('Adamax', $this->authentication->getUserName());
	}
	
	public function testGetUserRolesTrue() {
		$roles = $this->authentication->getUserRoles();
		$this->assertContains('user', $roles);
		$this->assertContains('admin', $roles);
	}
	
	public function testLogin() {		
		$userId = '1';
		$userName = 'Adamax';
		$userRoles = array('admin');
		
		$session = new HttpSession($this->mockConfiguration);		
		$this->authentication = new Authentication($session);
		$result = $this->authentication->login($userId, $userName, $userRoles);
		$this->assertTrue($result);
	}
	
	public function testLoginFalse() {
		$userId = '1';
		$userName = '';
		$userRoles = array();
		
		$session = new HttpSession($this->mockConfiguration);
		$this->authentication = new Authentication($session);
		$result = $this->authentication->login($userId, $userName, $userRoles);
		$this->assertFalse($result);
	}
}
