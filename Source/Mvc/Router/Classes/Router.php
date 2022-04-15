<?php

namespace Adamax\Mvc\Router\Classes;

require_once __DIR__.'/../../Controller/Classes/ControllerFactory.php';
require_once __DIR__.'/../Interfaces/Router.php';

use Adamax\Mvc\Controller\Classes\ControllerFactory;
use Adamax\Mvc\UrlMapper\Classes\Mapper as Mapper;

class Router implements \Adamax\Mvc\Router\Interfaces\Router {
	
	private $controllerFactory;
	private $mapper;

	public function __construct(Mapper $mapper, ControllerFactory $controllerFactory) {
		$this->mapper = $mapper;
		$this->controllerFactory = $controllerFactory;
	}

	public function dispatch($address) {
		$route = $this->mapper->getRoute($address);
		$controller = $this->controllerFactory->createController($route->getModule(), $route->getController(), $route);
		$response = $controller->run();
		$response->execute();
	}
}
