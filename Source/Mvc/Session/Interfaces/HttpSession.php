<?php

namespace Adamax\Mvc\Session\Interfaces;

require_once __DIR__.'/../Classes/SessionSection.php';

interface HttpSession {
	public function getAttribute(\Adamax\Mvc\Session\Classes\SessionSection $section, $name);
	public function getSection($name);
	public function hasSection($name);
	public function setAttribute(\Adamax\Mvc\Session\Classes\SessionSection $section, $name, $value);
}