<?php

namespace Controller\Front;

use App;

class FrontController extends \Controller\Controller{

	protected $layoutBlank = false;
	protected $outlinePath = "Front/Outline/";
	protected $topMenuCode = '';
	protected $subMenuCode = '';
	protected $footerMenuCode = '';

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
		App::render("Front/Menus/topMenu", ['topMenuCode' => $this->topMenuCode]);
	}

	public function subMenu(){
		if($this->layoutBlank == true){
			return;
		}
		App::render("Front/Menus/subMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){

	}

	public function footerMenu(){
		if($this->layoutBlank == true){
			return;
		}
		App::render("Front/Menus/footerMenu", ['footerMenuCode' => $this->footerMenuCode]);
	}

	public function footer(){
		if($this->layoutBlank == true){
			return;
		}
		App::render($this->outlinePath . "Footer/main");
	}
}