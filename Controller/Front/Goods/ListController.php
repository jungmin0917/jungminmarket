<?php

namespace Controller\Front\Goods;

use App;
use Component\Exception\AlertException;

class ListController extends \Controller\Front\FrontController{

	public function index(){
		try{

			$category = request()->get('category');

			if($category == 'new'){ // new인 경우

			}else if($category == 'best'){ // best인 경우

			}else{ // 나머지
				$goods = App::load(\Component\Goods\Goods::class);

				$page = request()->get('page');

				$page = $page?$page:1;
				$limit = 6;

				$goodsCount = $goods->getGoodsCountByCategory($category);

				$goodsData = $goods->getGoodsByCategory($category, $page, $limit);

				$categoryNm = $goods->getCategoryNm($category);

				App::render("Front/Goods/list", ['goodsList' => $goodsData['list'], 'categoryNm' => $categoryNm, 'pagination' => $goodsData['pagination'], 'goodsCount' => $goodsCount]);
			}

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}