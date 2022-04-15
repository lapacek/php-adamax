<?php

namespace Adamax\Configuration\Interfaces;

interface Configuration {
	public function getApplicationDefaultLanguage();
	public function getApplicationPath();
	public function getAllowedLanguages();
	public function getConfigPath();
	public function getDocumentRoot();
	public function getDatabaseParams();
	public function getFrameworkPath();
	public function getControllerPath();
	public function getImagesUploadPath();
	public function getImageTargetsMap();
	public function getModelPath();
	public function getTemplatePath();
	public function getTemporaryImageDirectory();
	public function getSessionName();
	public function getSessionTimeLimit();
	public function getSessionStoragePath();
	public function getUrlMapPath();
	public function getUrlMapFileName();
	public function getVocabularyPath();
}
