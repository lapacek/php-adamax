<?php

namespace Adamax\Configuration\Classes;

class DocumentRoot {
	private $value;
	
	public function __construct($value) {
		$this->value = $value;
	}
	
	public function getValue() {
		return $this->value;
	}
}