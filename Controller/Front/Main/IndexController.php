<?php

namespace Controller\Front\Main;

use App;

class IndexController extends \Controller\Front\FrontController{
	public function index(){
		App::render("Front/Main/index");
	}
}