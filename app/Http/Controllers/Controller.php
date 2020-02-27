<?php

namespace app\Http\Controllers;

use app\View;

abstract class Controller {

	public $route;
	public $view;
	public $middleware;

	public function __construct($route) {
		$this->route = $route;
		if (!$this->checkMiddleware()) {
			View::errorCode(403);
		}
		$this->view = new View($route);
		$this->model = $this->loadModel($route['controller']);
	}

	public function loadModel($name) {
		$path = 'app\\' . ucfirst($name);
		if (class_exists($path)) {
			return new $path;
		}
	}

	public function checkMiddleware() {
		$this->middleware = require 'app/Http/Middleware/' . $this->route['controller'] . 'Middleware.php';
		if ($this->isMiddleware('all')) {
			return true;
		}
		return false;
	}

	public function isMIddleware($key) {
		return in_array($this->route['action'], $this->middleware[$key]);
	}

}