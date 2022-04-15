<?php

namespace Controller\Test;

require_once __DIR__.'/../../../../../Source/Mvc/Controller/Classes/Controller.php';
require_once __DIR__.'/../../Response/Response.php';

use Adamax\Mvc\Controller\Classes\Controller;
use Response\TestResponse;

class Test extends Controller {
	public function run() {
	    return new TestResponse($this);
	}
}
