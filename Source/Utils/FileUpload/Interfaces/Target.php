<?php

namespace Adamax\Utils\FileUpload\Interfaces;

interface Target {
	public function getName();
	public function getDirectory();
	public function getWidth();
	public function getHeight();
}