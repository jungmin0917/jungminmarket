<?php

namespace Controller\Admin\Goods;

use App;
use Component\Exception\AlertException;

class ListController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'goods';
		$this->subMenuCode = 'goods_list';
	}

	public function subMenu(){
		App::render("Admin/Menus/goodsMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){
		try{
			$goods = App::load(\Component\Goods\Goods::class);

			$page = request()->get('page');

			$page = $page?$page:1;
			$limit = 5;

			$data = $goods->getGoodsList($page, $limit);

			App::render("Admin/Goods/list", $data);

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}