<?php

namespace Controller\Admin\Goods;

use App;

class ListController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'goods';
		$this->subMenuCode = 'goods_list';
	}

	public function subMenu(){
		App::render("Admin/Menus/goodsMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){

	}
}