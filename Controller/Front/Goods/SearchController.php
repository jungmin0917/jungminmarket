<?php

namespace Controller\Front\Goods;

use App;
use Component\Exception\AlertException;

class SearchController extends \Controller\Front\FrontController{
	public function index(){
		try{
			$goods = App::load(\Component\Goods\Goods::class);

			$page = request()->get('page');

			$page = $page?$page:1;
			$limit = 6;

			$searchWord = request()->get('search_word');

			$category = request()->get('category');

			$goodsData = $goods->getSearchedGoods($page, $limit, $searchWord);

			$goodsCount = $goodsData['total'];

			App::render("Front/Goods/list", ['goodsList' => $goodsData['list'], 'searchWord' => $searchWord, 'goodsCount' => $goodsCount, 'pagination' => $goodsData['pagination']]);
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}