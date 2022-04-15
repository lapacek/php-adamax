<?php

namespace Adamax\Utils\DoctrineEntityManagerFactory\Classes;

require_once __DIR__.'/../../../../../Doctrine2/vendor/autoload.php';
require_once __DIR__.'/../../../Configuration/Interfaces/Configuration.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DoctrineEntityManagerFactory {
	
	private static $entityManager;
	
	public static function createEntityManager(\Adamax\Configuration\Interfaces\Configuration $configuration) {
		if (\is_null(self::$entityManager)) {
			$modelPath = $configuration->getModelPath();
			$paths = array($modelPath);
			$isDevMode = TRUE;
			$dbParams = $configuration->getDatabaseParams();
			
			$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
			self::$entityManager = EntityManager::create($dbParams, $config);
		}
		return self::$entityManager;
	}
	
	public static function clear() {
		self::$entityManager = NULL;
	}
}