<?php

namespace Adamax\Core\Classes;

require_once __DIR__.'/../../Configuration/Classes/Configuration.php';
require_once __DIR__.'/../../FileParser/Classes/IniFileParser.php';
require_once __DIR__.'/../../Mvc/Controller/Classes/ControllerFactory.php';
require_once __DIR__.'/../../Mvc/Router/Classes/Router.php';
require_once __DIR__.'/../../Mvc/UrlMapper/Classes/Mapper.php';
require_once __DIR__.'/../Interfaces/Adamax.php';

use Adamax\FileParser\Classes\IniParser;
use Adamax\Mvc\Controller\Classes\ControllerFactory;
use Adamax\Mvc\Router\Classes\Router;
use Adamax\Mvc\UrlMapper\Classes\Mapper;

class Adamax implements \Adamax\Core\Interfaces\Adamax {
	
	private $configuration;
	
	public function __construct(\Adamax\Configuration\Classes\Configuration $configuration) {
		$this->configuration = $configuration;
	}
	
	public function run() {
		$parser = new IniParser();
		$urlMapper = new Mapper($this->configuration, $parser);
		$controllerFactory = new ControllerFactory($this->configuration, $urlMapper);
		$router = new Router($urlMapper, $controllerFactory);
		$url = $_GET['url'];
		$router->dispatch($url);
	}		
}