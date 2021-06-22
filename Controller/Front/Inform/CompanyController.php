<?php

namespace Controller\Front\Inform;

use App;

class CompanyController extends \Controller\Front\FrontController{

	public function index(){
		App::render("Front/Inform/company");
	}
}