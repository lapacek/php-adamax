<?php

namespace Adamax\Mvc\Request\Classes;

require_once __DIR__.'/../Interfaces/HttpRequest.php';

class HttpRequest implements \Adamax\Mvc\Request\Interfaces\HttpRequest {
	
	private $route;
	
	public function __construct(\Adamax\Mvc\UrlMapper\Interfaces\Route $route) {
		$this->route = $route;
	}
	
	public function isGet() {
		if ($this->hasRequestMethod()) {
			return $_SERVER['REQUEST_METHOD'] === 'GET';
		}
		return FALSE;
	}
	
	public function isPost() {
		if ($this->hasRequestMethod()) {
			return $_SERVER['REQUEST_METHOD'] === 'POST';
		}
		return FALSE;
	}
	
	public function getInput($name) {
		if ($this->hasGetInput($name)) {
			$result = $_GET[$name];
		} 
		if ($this->hasPostInput($name)) {
			$result = $_POST[$name];
		}
		if (empty($result) || \is_null($result)) {
			return NULL;
		}
		return $result;
	}
	
	public function getParameter($name) {
		$params = $this->route->getParams();
		if (\array_key_exists($name, $params)) {
			return $params[$name];
		}
		return \NULL;
	}
	
	public function hasGetInput($name) {
		return $this->isGet() && isset($_GET[$name]);
	}
	
	public function hasPostInput($name) {
		return $this->isPost() && isset($_POST[$name]);
	}
	
	public function hasParameter($name) {
		return $this->route->hasParameter($name);
	}
	
	private function hasRequestMethod() {
		return isset($_SERVER['REQUEST_METHOD']);
	}
	
	private function hasNoGetOrPostInput($name) {
		return !($this->hasGetInput($name) || $this->hasPostInput($name));
	}
}