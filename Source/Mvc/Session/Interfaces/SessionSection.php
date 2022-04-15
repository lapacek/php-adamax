<?php

namespace Adamax\Mvc\Session\Interfaces;

require_once __DIR__.'/../Interfaces/HttpSession.php';

interface SessionSection {
	public function __construct(\Adamax\Mvc\Session\Interfaces\HttpSession $session, $name);
	public function getAttribute($name);
	public function getName();
	public function setAttribute($name, $value);
}