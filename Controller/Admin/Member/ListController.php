<?php

namespace Controller\Admin\Member;

use App;

class ListController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'member';
		$this->subMenuCode = 'member_list';
	}

	public function subMenu(){
		App::render("Admin/Menus/memberMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){
		
	}
}