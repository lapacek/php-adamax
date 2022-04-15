<?php

namespace Adamax\Mvc\Response\Classes;

require_once __DIR__.'/HttpResponse.php';

class ViewResponse extends HttpResponse {	
	public function execute() {
		echo $this->controller->getView()->render();
	}	
}
