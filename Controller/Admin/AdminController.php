<?php

namespace Controller\Admin;

use App;

class AdminController extends \Controller\Controller{

	protected $layoutBlank = false;
	protected $outlinePath = "Admin/Outline/";
	protected $topMenuCode = '';
	protected $subMenuCode = '';

	public function header(){
		if($this->layoutBlank == true){
			return;
		}
		App::render($this->outlinePath . "Header/main");
	}

	public function topMenu(){
		if($this->layoutBlank == true){
			return;
		}
		App::render("Admin/Menus/topMenu", ['topMenuCode' => $this->topMenuCode]);
	}

	public function index(){

	}

	public function footer(){
		if($this->layoutBlank == true){
			return;
		}
		App::render($this->outlinePath . "Footer/main");
	}
}