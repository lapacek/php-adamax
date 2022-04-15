<?php

namespace Adamax\Mvc\Controller\Classes;

require_once __DIR__.'/../../../Configuration/Classes/Configuration.php';
require_once __DIR__.'/../../../Exception/Classes/ImplementationException.php';
require_once __DIR__.'/../../../Utils/Authentication/Interfaces/Authentication.php';
require_once __DIR__.'/../../UrlMapper/Interfaces/Mapper.php';
require_once __DIR__.'/../../Request/Interfaces/HttpRequest.php';
require_once __DIR__.'/../../Session/Interfaces/HttpSession.php';
require_once __DIR__.'/../../View/Interfaces/View.php';
require_once __DIR__.'/../Interfaces/Controller.php';

use Adamax\Exception\Classes\ImplementationException;

abstract class Controller implements \Adamax\Mvc\Controller\Interfaces\Controller {
	
	protected $authentication;
	protected $configuration;
	protected $mapper;
	protected $request;
	protected $session;
	protected $view;
	
	public function isGet() {
		return $this->request->isGet();
	}
	
	public function isPost() {
		return $this->request->isPost();
	}
	
	public function run() {
		throw new ImplementationException('This method must be implemented.');
	}
	
	public function getConfiguration() {
		return $this->configuration;
	}

	public function setMapper(\Adamax\Mvc\Mapper\Interfaces\Mapper $mapper) {
		$this->mapper = $mapper;
	}

	public function setAuthentication(\Adamax\Utils\Authentication\Interfaces\Authentication $authentication) {
		$this->authentication = $authentication;
	}

	public function setConfiguration(\Adamax\Configuration\Interfaces\Configuration $configuration) {
		$this->configuration = $configuration;
	}

	public function setRequest(\Adamax\Mvc\Request\Interfaces\HttpRequest $request) {
		$this->request = $request;
	}

	public function setSession(\Adamax\Mvc\Session\Interfaces\HttpSession $session) {
		$this->session = $session;
	}
	
	public function setView(\Adamax\Mvc\View\Classes\View $view) {
		$this->view = $view;
	}
	
	public function getView() {
		return $this->view;
	}
	
	public function redirect($module, $controller, $action, $params = array()) {
		$address = $this->createUrl($module, $controller, $action, $params);
		$url = $this->createtUrlForRedirect($address);
		$this->location($url);
	}
	
	protected function createUrl($module, $controller, $action, $params) {
		return $this->mapper->createAddress($module, $controller, $action, $params);
	}
	
	private function createtUrlForRedirect($address) {
		return (\array_key_exists('HTTPS', $_SERVER) ? 'https' : 'http' ).'://'.$_SERVER['HTTP_HOST'].$address;
	}
	
	private function location($url) {
		\header('Location: '. $url);
		exit();
	}
}
