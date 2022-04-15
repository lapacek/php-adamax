<?php

namespace Adamax\Mvc\View\Interfaces;

interface View {
	public function addComponent($name, View $view);
	public function display();
	public function setData($name, $value);
	public function render();
}