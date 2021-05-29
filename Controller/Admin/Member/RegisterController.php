<?php

namespace Controller\Admin\Member;

use App;

class RegisterController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'member';
		$this->subMenuCode = 'member_register';
	}

	public function subMenu(){
		App::render("Admin/Menus/memberMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){
		App::render("Admin/Member/register");
	}
}