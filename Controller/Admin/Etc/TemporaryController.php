<?php

namespace Controller\Admin\Etc;

use App;

class TemporaryController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'etc';
		$this->subMenuCode = 'etc_temporary';
	}

	public function subMenu(){
		App::render("Admin/Menus/etcMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){
		App::render("Admin/Etc/temporary");
	}
}