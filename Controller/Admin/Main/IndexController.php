<?php

namespace Controller\Admin\Main;

use App;

class IndexController extends \Controller\Admin\AdminController{
	public function index(){
		App::render("Admin/Main/index");
	}
}