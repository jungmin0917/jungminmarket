<?php

namespace Controller\Front\Inform;

use App;

class QuestionController extends \Controller\Front\FrontController{

	public function index(){
		App::render("Front/Inform/question");
	}
}