<?php

namespace Controller\Test;

require_once __DIR__.'/../../../../../../Source/Mvc/Controller/Classes/Controller.php';

use Adamax\Mvc\Controller\Classes\Controller;

class MockController extends Controller {
	public function run() {
		return TRUE;
	}
}