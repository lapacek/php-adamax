<?php

namespace Adamax\Mvc\UrlMapper\Classes;

require_once __DIR__.'/Route.php';
require_once __DIR__.'/../Interfaces/Mapper.php';
require_once __DIR__.'/../../../Configuration/Classes/Configuration.php';
require_once __DIR__.'/../../../Exception/Classes/InvalidUrlMapException.php';
require_once __DIR__.'/../../../Exception/Classes/RouteNotFoundException.php';
require_once __DIR__.'/../../../FileParser/Classes/IniFileParser.php';

use Adamax\Configuration\Classes\Configuration as Configuration;
use Adamax\Exception\Classes\InvalidUrlMapException;
use Adamax\Exception\Classes\RouteNotFoundException;
use Adamax\FileParser\Classes\IniParser as IniParser;
use Adamax\Mvc\UrlMapper\Classes\Route;

class Mapper implements \Adamax\Mvc\Mapper\Interfaces\Mapper {
	
	private $application;
	private $parser;
	private $routes;

	public function __construct(Configuration $configuration, IniParser $parser) {
		$this->configuration = $configuration;
		$this->parser = $parser;
		$this->initializeRoutes();
	}
	
	public function createAddress($module, $controller, $action, $params = array()) {
		foreach ($this->routes as $route) {
			if ($route->isNotModuleEqualAs($module)) continue;
			if ($route->isNotControllerEqualAs($controller)) continue;
			if ($route->isNotActionEqualAs($action)) continue;
			return $route->createAddress($params);
		}
		throw new RouteNotFoundException('Route for module: '. $module. ', controller: '. $controller. ', action: '. $action. ' is not found.');
	}

	public function getRoute($address) {
		$urlAddress = \trim($address, '/');
		$addressFragments = \explode('/', $urlAddress);
		foreach ($this->routes as $route) {
			$urlPattern = \trim($route->getPattern(), '/');
			$patternFragments = \explode("/", $urlPattern);
			$checkedFragments = array();
			$params = array();
			foreach ($patternFragments as $key => $fragment) {
				$pattern = $addressFragments[$key];
				if (\preg_match('/^[a-zA-Z\-]*$/', $fragment) === 1) {
					if (\preg_match('/^'.$fragment.'$/', $pattern) === 0) {
						$checkedFragments = array();
						break;
					}
					$checkedFragments[] = $fragment;
				} else if (\preg_match('/^\([a-zA-Z]+\)$/', $fragment) === 1) {
					$paramName = \trim($fragment, '()');
					$params[$paramName] = $pattern;
					$checkedFragments[] = $fragment;
				}
			}
			if (!empty($checkedFragments)) {
				if (\count($addressFragments) === \count($checkedFragments)) {
					$route->setParams($params);
					return $route;
				}
			}
		}
		throw new RouteNotFoundException('Route for address "'.$address.'" is not found.');
	}

	private function initializeRoutes() {
		$map = $this->loadMap();
		$this->routes = array();
		foreach ($map as $key => $record) {
			$this->createRouteForRecordAndAddItToRoutes($record);
		}
	}

	private function loadMap() {
		return $this->parse();
	}

	private function parse() {
		$file = $this->getUrlMapPath();
		return $this->parser->parse($file);
	}
	
	private function getUrlMapPath() {
		return $this->configuration->getUrlMapPath();	
	}
	
	private function createRouteForRecordAndAddItToRoutes($record) {
		if ($this->hasRecordAllRequiredKeys($record)) {
			$route = Route::createRoute($record);
			$this->routes[$record['pattern']] = $route;
		} else {
			throw new InvalidUrlMapException('Invalid url map.');						
		}
	}
	
	private function hasRecordAllRequiredKeys($record) {
		return ($this->hasRecordKey($record, 'module') && 
			$this->hasRecordKey($record, 'controller') && 
			$this->hasRecordKey($record, 'pattern') && 
			$this->hasRecordKey($record, 'action'));
	}
	
	private function hasRecordKey($record, $key) {
		return \array_key_exists($key, $record);
	}
}
