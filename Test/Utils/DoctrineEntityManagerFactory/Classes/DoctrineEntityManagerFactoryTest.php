<?php

require_once  __DIR__.'/../../../../../Doctrine2//vendor/autoload.php';
require_once __DIR__.'/../../../../../Doctrine2/lib/Doctrine/ORM/EntityManager.php';
require_once __DIR__.'/../../../../Source/Configuration/Classes/Configuration.php';
require_once __DIR__.'/../../../../Source/Utils/DoctrineEntityManagerFactory/Classes/DoctrineEntityManagerFactory.php';

use Adamax\Utils\DoctrineEntityManagerFactory\Classes\DoctrineEntityManagerFactory;

class DoctrineEntityManagerFactoryTest extends PHPUnit_Framework_TestCase {
	
	protected $entityManager;
	
	protected function setUp() {
		$mockConfiguration = $this->getMockBuilder('Adamax\Configuration\Classes\Configuration')
											->disableOriginalConstructor()
											->getMock();
		
		$dbPath = __DIR__.'/../Database/Test.db';
		$dbParams = array(
						'driver' => 'pdo_sqlite', 
						'user' => '', 
						'password' => '', 
						'path' => $dbPath, 
						'memory' => TRUE);
		$mockConfiguration->expects($this->any())
						->method('getDatabaseParams')
						->will($this->returnValue($dbParams));
		
		$this->entityManager = DoctrineEntityManagerFactory::createEntityManager($mockConfiguration);
	}
	
	protected function tearDown() {
		DoctrineEntityManagerFactory::clear();
	}

	public function testEntityManager() {
		$this->assertInstanceOf('\Doctrine\ORM\EntityManager', $this->entityManager); 
	}
}