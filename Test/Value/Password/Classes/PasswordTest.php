<?php

require_once __DIR__.'/../../../../Source/Value/Password/Classes/Password.php';

use Adamax\Value\Password\Classes\Password;

class PasswordTest {
	
	protected $password;
	
	protected function setUp() {
		$this->password = new Password();
	}
	
	public function testCreateSalt() {
		$salt = $this->password->createSalt();
		$this->assertEquals('xxxxyyyyzzzzwwww', $salt);
	}
	
	public function testCreateHashPassword() {
		$expect = 'a86e6d4e220cc4985df38b20bc72cfd5636dcdf75220730f54c6c43ad1bf5318';
		$salt = $this->password->createSalt();
		$password = 'Ne9pj&@u}y([Z4r#';
		$result = $this->password->createHashPassword($salt, $password);
		$this->assertEquals($expect, $result);
	}
}
