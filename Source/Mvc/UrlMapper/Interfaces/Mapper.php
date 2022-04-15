<?php

namespace Adamax\Mvc\Mapper\Interfaces;

interface Mapper {
	public function createAddress($module, $controller, $action, $params);
	public function getRoute($address);
}
