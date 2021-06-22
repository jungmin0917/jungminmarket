<?php

namespace Controller\Front\Inform;

use App;

class UseController extends \Controller\Front\FrontController{

	public function index(){
		App::render("Front/Inform/use");
	}
}