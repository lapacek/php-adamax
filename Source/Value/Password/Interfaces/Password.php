<?php

namespace Adamax\Value\Password\Interfaces;

interface Password {
	public function createHashPassword($salt, $password);
	public function createSalt();
}