<?php

namespace Controller\Front\Inform;

use App;

class TermsController extends \Controller\Front\FrontController{

	public function index(){
		App::render("Front/Inform/terms");
	}
}