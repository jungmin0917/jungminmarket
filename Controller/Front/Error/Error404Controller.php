<?php

namespace Controller\Front\Error;

use App;

class Error404Controller extends \Controller\Front\FrontController{

	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		App::render("Front/Error/error404");
	}
}