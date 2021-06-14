<?php

namespace Controller\Admin\Goods;

use App;
use Component\Exception\AlertException;

class CategoryController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'goods';
		$this->subMenuCode = 'goods_category';
	}

	public function subMenu(){
		App::render("Admin/Menus/goodsMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){
		try{

			$goods = App::load(\Component\Goods\Goods::class);

			$categoryList = $goods->getCategoryList();

			App::render("Admin/Goods/category", ['categoryList' => $categoryList]);

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}