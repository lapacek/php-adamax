<?php

namespace Adamax\Utils\Authentication\Interfaces;

interface Authentication {
	public function getUserId();
	public function getUserName();
	public function getUserRoles();
	public function hasUserRole($role);
	public function isLogged();
	public function login($userId, $userName, $userRoles);
}