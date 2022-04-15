<?php

namespace Adamax\Mvc\UrlMapper\Classes;

require_once __DIR__.'/../Interfaces/Route.php';

class Route implements \Adamax\Mvc\UrlMapper\Interfaces\Route {

	private $module;
	private $controller;
	private $action;
	private $pattern;
	private $params;
	
	public function setModule($module) {
		$this->module = $module;
	}
	
	public function setController($controller) {
		$this->controller = $controller;
	}
	
	public function setAction($action) {
		$this->action = $action;
	}
	
	public function setPattern($pattern) {
		$this->pattern = $pattern;
	}
	
	public function setParams(array $params) {
		$this->params = $params;
	}
	
	public function getRoute() {
		return \ucfirst($this->module). '/'. \ucfirst($this->controller);
	}
	
	public function getRouteAction() {
		return \lcfirst($this->action);
	}
	
	public function getModule() {
		return $this->module;
	}
	
	public function getController() {
		return $this->controller;
	}
	
	public function getAction() {
		return $this->action;
	}
	
	public function getPattern() {
		return $this->pattern;
	}
	
	public function getParams() {
		return $this->params;
	}
	
	public function isNotModuleEqualAs($module) {
		return $this->module !== $module;
	}
	
	public function isNotControllerEqualAs($controller) {
		return $this->controller !== $controller;
	}
	
	public function isNotActionEqualAs($action) {
		return $this->action !== $action;
	}
	
	public function createAddress($params) {
			$address = $this->getPattern();
			foreach ($params as $paramName => $paramValue) {
				$pattern = '/\('. $paramName. '\)/';
				$address = \preg_replace($pattern, $paramValue, $address);
			}
			return $address;
	}
	
	public static function createRoute($record) {
				$route = new Route();
				$route->setModule($record['module']);
				$route->setController($record['controller']);
				$route->setPattern($record['pattern']);
				$route->setAction($record['action']);
				return $route;
	}
	
	public static function createRouteTo(
		$module, $controller, $action, $params = array()
	) {
		$route = new Route();
		$route->setModule($module);
		$route->setController($controller);
		$route->setAction($action);
		$route->setParams($params);
		
		return $route;
	}

	public function hasParameter($name) {
		return \array_key_exists($name, $this->params);
	}
}