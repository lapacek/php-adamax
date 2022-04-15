<?php

namespace Adamax\Mvc\UrlMapper\Interfaces;

interface Route {
	public function getRoute();
	public function getRouteAction();
	public function getModule();
	public function getController();
	public function getAction();
	public function getPattern();
	public function getParams();
	public function hasParameter($name);
	public function setModule($module);
	public function setController($controller);
	public function setAction($action);
	public function setPattern($pattern);
	public function setParams(array $params);
}