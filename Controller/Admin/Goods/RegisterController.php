<?php

namespace Controller\Admin\Goods;

use App;

class RegisterController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'goods';
		$this->subMenuCode = 'goods_register';
	}

	public function subMenu(){
		App::render("Admin/Menus/goodsMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){
		$goods = App::load(\Component\Goods\Goods::class);

		$categoryList = $goods->getCategory();

		App::render("Admin/Goods/register");
	}
}