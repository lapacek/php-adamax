<?php

namespace Adamax\Mvc\Response\Classes;

require_once __DIR__.'/../../Controller/Classes/Controller.php';
require_once __DIR__.'/../../UrlMapper/Classes/Route.php';
require_once __DIR__.'/HttpResponse.php';

class RedirectResponse extends HttpResponse {
	private $route;
	
	public function __construct(\Adamax\Mvc\Controller\Classes\Controller $controller, 
								\Adamax\Mvc\UrlMapper\Classes\Route $route) {
		parent::__construct($controller);
		$this->route = $route;
	}
	
	public function execute() {
		$this->controller->redirect(
			$this->route->getModule(),
			$this->route->getController(),
			$this->route->getAction(),
			$this->route->getParams()
		);
	}	
}