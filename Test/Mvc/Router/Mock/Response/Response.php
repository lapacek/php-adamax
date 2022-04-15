<?php

namespace Response; 

require_once __DIR__.'/../../../../../Source/Mvc/Response/Classes/HttpResponse.php';

use Adamax\Mvc\Response\Classes\HttpResponse;

class RouterTestResponse extends HttpResponse {
	public function execute() {
	    echo "Hello Test!";
	}
}
