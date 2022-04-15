<?php

namespace Adamax\Configuration\Classes;

require_once __DIR__.'/../../FileParser/Interfaces/Parser.php';
require_once __DIR__.'/../Interfaces/Configuration.php';
require_once __DIR__.'/DocumentRoot.php';

use \Adamax\Configuration\Classes\DocumentRoot;

class Configuration implements \Adamax\Configuration\Interfaces\Configuration {
	
	private $parser;
	private $configuration;
	private $configurationFile;
	private $documentRoot;
	
	public function __construct(\Adamax\FileParser\Interfaces\Parser $parser, 
								\Adamax\Utils\File\Interfaces\File $file, 
								DocumentRoot $documentRoot) {
		$this->configurationFile = $file;
		$this->parser = $parser;
		$this->documentRoot = $documentRoot;
		$this->loadConfiguration();
	}
	
	public function getApplicationDefaultLanguage() {
		$language = $this->configuration['Application']['DefaultLanguage'];
		return \strtolower($language);
	}
	
	public function getApplicationPath() {
		return $this->documentRoot->getValue(). $this->configuration['Config']['ApplicationPath'];
	}
	
	public function getAllowedLanguages() {
		return \explode(', ', $this->configuration['Application']['AllowedLanguages']);
	}

	public function getConfigPath() {
		return $this->documentRoot->getValue(). $this->configuration['Config']['ConfigPath'];
	}
	
	public function getDocumentRoot() {
		return $this->documentRoot->getValue();
	}

	public function getControllerPath() {
		return $this->documentRoot->getValue(). $this->configuration['Application']['ControllerPath'];
	}

	public function getFrameworkPath() {
		return $this->documentRoot->getValue(). $this->configuration['Config']['FrameworkPath'];		
	}
	
	public function getDatabaseParams() {
		return $this->configuration['Database'];
	}
	
	public function getImagesUploadPath() {
		return $this->documentRoot->getValue(). $this->configuration['Config']['ImagesUploadPath'];
	}
	
	public function getImageTargetsMap() {
		$root = $this->documentRoot->getValue();
		$targetsMap = $this->configuration['Config']['ImageTargetsMap'];
		if (!empty($targetsMap)) {
			return $root. $targetsMap;
		}
		return $root.'Config/ImageTargetsMap.ini';
	}

	public function getModelPath() {
		return $this->documentRoot->getValue(). $this->configuration['Application']['ModelPath'];
	}

	public function getTemplatePath() {
		$templatePaths = $this->configuration['Application']['TemplatePath'];
		$root = $this->documentRoot->getValue();
		$result = \preg_replace('/\{DOCUMENT_ROOT}/', $root, $templatePaths);
		return $result;		
	}
	
	public function getTemporaryImageDirectory() {
		return $this->documentRoot->getValue(). $this->configuration['Config']['TemporaryImageDirectory'];
	}

	public function getSessionName() {
		return $this->configuration['Session']['Name'];
	}

	public function getSessionTimeLimit() {
		return $this->configuration['Session']['TimeLimit'];
	}

	public function getSessionStoragePath() {
		return $this->configuration['Session']['StoragePath'];		
	}

	public function getUrlMapFileName() {
		return $this->configuration['Config']['UrlMapFileName'];		
	}

	public function getUrlMapPath() {
		$root = $this->documentRoot->getValue();
		$urlMapPath = $this->configuration['Config']['UrlMapPath'];
		if (!empty($urlMapPath)) {
			return $root. $urlMapPath;
		}
		return $root.'Config/UrlMap.ini';
	}
	
	private function loadConfiguration() {
		$file = $this->configurationFile->getName();
		$this->configuration = $this->parser->parse($file);
	}

	public function getVocabularyPath() {
		return $this->documentRoot->getValue(). $this->configuration['Application']['VocabularyPath'];
	}
}
