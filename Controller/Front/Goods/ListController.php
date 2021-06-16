<?php

namespace Controller\Front\Goods;

use App;
use Component\Exception\AlertException;

class ListController extends \Controller\Front\FrontController{

	public function index(){
		try{
			$category = request()->get('category');

			$goods = App::load(\Component\Goods\Goods::class);

			$page = request()->get('page');

			$page = $page?$page:1;
			$limit = 6;

			$goodsData = $goods->getGoodsByCategory($category, $page, $limit);

			$categoryNm = $goods->getCategoryNm($category);

			App::render("Front/Goods/list", ['goodsList' => $goodsData['list'], 'categoryNm' => $categoryNm, 'pagination' => $goodsData['pagination']]);

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}