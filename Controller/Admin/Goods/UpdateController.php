<?php

namespace Controller\Admin\Goods;

use App;
use Component\Exception\AlertException;

class UpdateController extends \Controller\Admin\AdminController{

	public function __construct(){
		$this->topMenuCode = 'goods';
		$this->subMenuCode = 'goods_update';
	}

	public function subMenu(){
		App::render("Admin/Menus/goodsMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){
		try{
			$goods = App::load(\Component\Goods\Goods::class);

			$goodsNo = request()->get('goodsNo');

			$goodsData = $goods->getGoods($goodsNo);

			$categoryList = $goods->getCategoryList();

			App::render("Admin/Goods/register", ['categoryList' => $categoryList, 'goodsData' => $goodsData]);

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}