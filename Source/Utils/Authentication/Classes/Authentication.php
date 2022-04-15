<?php

namespace Adamax\Utils\Authentication\Classes;

require_once __DIR__.'/../../../Mvc/Session/Classes/HttpSession.php';
require_once __DIR__.'/../Interfaces/Authentication.php';

class Authentication implements \Adamax\Utils\Authentication\Interfaces\Authentication {
	
	private $section;
	private $sectionName = 'userLogin';
	private $session;

	public function __construct(\Adamax\Mvc\Session\Interfaces\HttpSession $session) {
		$this->session = $session;
		$this->section = $this->session->getSection($this->sectionName);
	}
	
	public function getUserId() {
		return $this->section->getAttribute('id');
	}

	public function getUserName() {
		return $this->section->getAttribute('userName');
	}

	public function getUserRoles() {
		return $this->section->getAttribute('roles');
	}
	
	public function hasUserRole($role) {
		$roles = $this->section->getAttribute('roles');
		return \in_array($role, $roles);
	}

	public function isLogged() {
		return $this->session->hasSection($this->sectionName);
	}
	
	public function login($userId, $userName, $userRoles) {
		if ($this->isUserValuesValid($userId, $userName, $userRoles)) {
			$this->section->setAttribute('id', $userId);
			$this->section->setAttribute('userName', $userName);
			$this->section->setAttribute('roles', $userRoles);
			
			return TRUE;
		}
		return FALSE;
	}
	
	private function isUserValuesValid($userId, $userName, $userRoles) {
		if ($this->isNotValueValid($userId)) return FALSE;
		if ($this->isNotValueValid($userName)) return FALSE;
		if ($this->isNotValueValid($userRoles)) return FALSE;
		
		return TRUE;
	}
	
	private function isNotValueValid($value) {
		return empty($value) || \is_null($value);
	}
}