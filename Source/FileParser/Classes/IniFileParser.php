<?php

namespace Adamax\FileParser\Classes;

require_once __DIR__.'/../Interfaces/Parser.php';

class IniParser implements \Adamax\FileParser\Interfaces\Parser {

	public function parse($file) {
		return \parse_ini_file($file, TRUE);		
	}
}
