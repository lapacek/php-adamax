<?php

namespace Adamax\Mvc\Response\Classes;

require_once __DIR__.'/../../../Exception/Classes/ImplementationException.php';
require_once __DIR__.'/../../Controller/Classes/Controller.php';
require_once __DIR__.'/../Interfaces/HttpResponse.php';

abstract class HttpResponse implements \Adamax\Mvc\Response\Interfaces\HttpResponse {
	protected $controller;
	
	public function __construct(\Adamax\Mvc\Controller\Classes\Controller $controller) {
		$this->controller = $controller;	
	}
	
	public function execute() {
		throw new \Adamax\Exception\Classes\ImplementationException();
	}	
}