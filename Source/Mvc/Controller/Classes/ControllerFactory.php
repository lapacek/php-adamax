<?php

namespace Adamax\Mvc\Controller\Classes;

require_once __DIR__.'/../../../Configuration/Classes/Configuration.php';
require_once __DIR__.'/../../../Exception/Classes/ControllerNotFoundException.php';
require_once __DIR__.'/../../../Mvc/Request/Classes/HttpRequest.php';
require_once __DIR__.'/../../../Mvc/Session/Classes/HttpSession.php';
require_once __DIR__.'/../../../Mvc/UrlMapper/Classes/Mapper.php';
require_once __DIR__.'/../../../Utils/Authentication/Classes/Authentication.php';
require_once __DIR__.'/../Interfaces/ControllerFactory.php';

use Adamax\Configuration\Classes\Configuration;
use Adamax\Exception\Classes\ControllerNotFoundException;
use Adamax\Mvc\Request\Classes\HttpRequest;
use Adamax\Mvc\Session\Classes\HttpSession;
use Adamax\Utils\Authentication\Classes\Authentication;

class ControllerFactory implements \Adamax\Mvc\Controller\Interfaces\ControllerFactory {
	
	private $configuration;
	private $mapper;

	public function __construct(Configuration $configuration, \Adamax\Mvc\UrlMapper\Classes\Mapper $mapper) {
		$this->configuration = $configuration;
		$this->mapper = $mapper;
	}
	
	public function createController($moduleName, $controllerName, \Adamax\Mvc\UrlMapper\Interfaces\Route $route) {
		$controllerPath = $this->configuration->getControllerPath();
		$controllerFile = $controllerPath. $moduleName. '/'. $controllerName. '.php';
		if (\file_exists($controllerFile)) {
			require_once $controllerFile;
			$controllerNameWithNamespace = '\\Controller\\'. $moduleName. '\\'. $controllerName;
			if (\class_exists($controllerNameWithNamespace)) {
				$controller = new $controllerNameWithNamespace;
				$controller->setConfiguration($this->configuration);
				$session = new HttpSession($this->configuration);
				$controller->setRequest(new HttpRequest($route));
				$controller->setSession($session);
				$controller->setAuthentication(new Authentication($session));
				$controller->setMapper($this->mapper);
				return $controller;
			}
		}
		throw new ControllerNotFoundException();
	}
}