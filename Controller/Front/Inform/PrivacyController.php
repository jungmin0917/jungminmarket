<?php

namespace Controller\Front\Inform;

use App;

class PrivacyController extends \Controller\Front\FrontController{

	public function index(){
		App::render("Front/Inform/privacy");
	}
}