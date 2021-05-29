<?php

namespace Controller\Admin\Board;

use App;

class BannerController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'board';
		$this->subMenuCode = 'board_banner';
	}

	public function subMenu(){
		App::render("Admin/Menus/boardMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){

	}
}