<?php

namespace Adamax\Mvc\Request\Interfaces;

require_once __DIR__.'/../../UrlMapper/Interfaces/Route.php';

interface HttpRequest {
	public function isGet();
	public function isPost();
	public function getInput($name);
	public function getParameter($name);
	public function hasParameter($name);
}