<?php

namespace Controller\Front\Goods;

use App;
use Component\Exception\AlertException;

class ListController extends \Controller\Front\FrontController{

	public function index(){
		try{
			$category = request()->get('category');

			$goods = App::load(\Component\Goods\Goods::class);

			$goodsList = $goods->getGoodsByCategory($category);

			$categoryNm = $goods->getCategoryNm($category);

			App::render("Front/Goods/list", ['goodsList' => $goodsList, 'categoryNm' => $categoryNm]);

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}