<?php

require_once __DIR__.'/../../../../Source/Configuration/Classes/Configuration.php';
require_once __DIR__.'/../../../../Source/Utils/File/Classes/File.php';
require_once __DIR__.'/../../../../Source/Exception/Classes/FileNotExistsException.php';
require_once __DIR__.'/../../../../Source/Mvc/View/Classes/View.php';

use Adamax\Utils\File\Classes\File;
use Adamax\Mvc\View\Classes\View;

class ViewTest extends PHPUnit_Framework_TestCase {
	
	protected $view;
	protected $mockConfiguration;

	protected function setUp() {
		$messagesData = array(
							array(
								'title' => 'Good news',
								'content' => 'With funny content'
							));
		
		$this->mockConfiguration = $this->getMockBuilder('Adamax\Configuration\Classes\Configuration')
							->disableOriginalConstructor()
							->getMock();
		$this->mockConfiguration->expects($this->any())
					->method('getLayoutsDirectoryPath')
					->will($this->returnValue(__DIR__.'/../Template/'));
					
		$this->mockConfiguration->expects($this->any())
					->method('getViewsDirectoryPath')
					->will($this->returnValue(__DIR__.'/../Template/'));
		
		$layoutFile = new File(__DIR__.'/../Template/layout.html');
		$siteFile = new File(__DIR__.'/../Template/site.html');
		$messagesFile = new File(__DIR__.'/../Template/messages.html');
							
		$viewLayout = new View($layoutFile);
		$viewSite = new View($siteFile);
		$viewMessages = new View($messagesFile);
		
		$viewMessages->setData('messages', $messagesData);
		$viewSite->addComponent('messages', $viewMessages);
		$viewLayout->addComponent('content', $viewSite);
		$this->view = $viewLayout;
	}
	
	public function testRenderSuccess() {
		$expected = __DIR__.'/../Template/Output/success.html';
		$result = $this->view->render();
		$this->assertStringEqualsFile($expected, $result);
	}
}