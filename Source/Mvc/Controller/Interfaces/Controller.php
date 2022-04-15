<?php

namespace Adamax\Mvc\Controller\Interfaces;

require_once __DIR__.'/../../../Configuration/Interfaces/Configuration.php';
require_once __DIR__.'/../../../Utils/Authentication/Interfaces/Authentication.php';
require_once __DIR__.'/../../Request/Interfaces/HttpRequest.php';
require_once __DIR__.'/../../Session/Interfaces/HttpSession.php';
require_once __DIR__.'/../../UrlMapper/Interfaces/Mapper.php';

interface Controller {
	public function isGet();
	public function isPost();
	public function run();
	public function setMapper(\Adamax\Mvc\Mapper\Interfaces\Mapper $mapper);
	public function setAuthentication(\Adamax\Utils\Authentication\Interfaces\Authentication $authentication);
	public function setConfiguration(\Adamax\Configuration\Interfaces\Configuration $configuration);
	public function setRequest(\Adamax\Mvc\Request\Interfaces\HttpRequest $request);
	public function setSession(\Adamax\Mvc\Session\Interfaces\HttpSession $session);
}