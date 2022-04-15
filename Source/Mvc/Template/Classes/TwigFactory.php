<?php

namespace Adamax\Mvc\Template\Classes;

require_once __DIR__.'/../../../../../Twig/lib/Twig/Autoloader.php';

class TwigFactory {
	public static function getTwig() {
		\Twig_Autoloader::register();
		//$loader = new \Twig_Loader_Filesystem('/path/to/templates');
		$loader = new \Twig_Loader_String();
		$twig = new \Twig_Environment($loader);
		
		return $twig;
	}
}