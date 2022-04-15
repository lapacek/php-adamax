<?php

namespace Adamax\Utils\FileUpload\Interfaces;

require_once __DIR__.'/Target.php';

interface Image {
	public function addTarget(Target $target);
	public function getCreated();
	public function getError();
	public function getHashName();
	public function getInputName();
	public function getName();
	public function getTemporaryPath();
	public function getTargets();
	public function setTemporaryPath($temporaryPath);
}