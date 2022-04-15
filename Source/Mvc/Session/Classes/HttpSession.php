<?php

namespace Adamax\Mvc\Session\Classes;

require_once __DIR__.'/../../../Configuration/Interfaces/Configuration.php';
require_once __DIR__.'/../Interfaces/HttpSession.php';
require_once __DIR__.'/SessionSection.php';

use Adamax\Mvc\Session\Classes\SessionSection;

class HttpSession implements \Adamax\Mvc\Session\Interfaces\HttpSession {
	
	private $configuration;
	private $sections;

	public function __construct(\Adamax\Configuration\Interfaces\Configuration $configuration) {
		$this->configuration = $configuration;
		$this->initialize();
	}
	
	public function __destruct() {
		\session_write_close();
	}
	
	public function getAttribute(\Adamax\Mvc\Session\Classes\SessionSection $section, $name) {
		$sectionName = $section->getName();
		if (\array_key_exists($name, $_SESSION[$sectionName])) {
			return $_SESSION[$sectionName][$name];
		}
		return \NULL;
	}
	
	public function getSection($name) {
		if (\array_key_exists($name, $this->sections)) {
			return $this->sections[$name];
		}
		$section = new SessionSection($this, $name);
		$this->sections[$name] = $section;
		return $section;
	}

	public function hasSection($name) {
		return \array_key_exists($name, $this->sections);
	}

	public function setAttribute(\Adamax\Mvc\Session\Classes\SessionSection $section, $name, $value) {
		$sectionName = $section->getName();
		$_SESSION[$sectionName][$name] = $value;		
	}
	
	public function regenerateId() {
		\session_regenerate_id();
	}
	
	private function initialize() {
		\ini_set('session.use_only_cookies', TRUE);
		\ini_set('session.use_trans_sid', FALSE);
		\ini_set('session.save_path', $this->configuration->getSessionStoragePath());
		\ini_set('session.gc_maxlifetime', $this->configuration->getSessionTimeLimit());
		\session_name($this->configuration->getSessionName());
		if (!\headers_sent()) {
			\session_start();
		}
		$this->sections = array();
	}
}