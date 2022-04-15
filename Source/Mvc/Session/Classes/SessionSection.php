<?php

namespace Adamax\Mvc\Session\Classes;

require_once __DIR__.'/../Interfaces/SessionSection.php';

class SessionSection implements \Adamax\Mvc\Session\Interfaces\SessionSection {
	
	private $name;
	private $session;

	public function __construct(\Adamax\Mvc\Session\Interfaces\HttpSession $session, $name) {
		$this->name = $name;
		$this->session = $session;
	}
	
	public function getAttribute($name) {
		return $this->session->getAttribute($this, $name);
	}
	
	public function getName() {
		return $this->name;
	}

	public function setAttribute($name, $value) {
		$this->session->setAttribute($this, $name, $value);
	}
}