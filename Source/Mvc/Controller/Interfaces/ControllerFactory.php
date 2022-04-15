<?php

namespace Adamax\Mvc\Controller\Interfaces;

require_once __DIR__.'/../../../../Source/Mvc/UrlMapper/Interfaces/Route.php';

interface ControllerFactory {
	public function createController($moduleName, $controllerName, \Adamax\Mvc\UrlMapper\Interfaces\Route $route);
}