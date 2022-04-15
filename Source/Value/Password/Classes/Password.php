<?php

namespace Adamax\Value\Password\Classes;

require_once __DIR__.'/../Interfaces/Password.php';

class Password implements \Adamax\Value\Password\Interfaces\Password {
	
	public function createHashPassword($salt, $password) {
		$half = (int)(\strlen($salt)/2);
		return \hash('sha256', \substr($salt, 0, $half).$password.\substr($salt, $half));
	}

	public function createSalt() {
		return 'xxxxyyyyzzzzwwww';
	}	
}