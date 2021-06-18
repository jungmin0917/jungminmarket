<?php

namespace Controller\Front\Goods;

use App;
use Component\Exception\AlertException;

class ListController extends \Controller\Front\FrontController{

	public function index(){
		try{
			// 공통 부분
			$goods = App::load(\Component\Goods\Goods::class);

			$page = request()->get('page');

			$page = $page?$page:1;
			$limit = 6;

			$category = request()->get('category');

			if($category == 'new'){ // new인 경우

				if($page > 5){ // 페이지를 일부러 5보다 크게 넣은 경우
					go("goods/list?category=new&page=5");
				}

				$goodsData = $goods->getNewGoods($page, $limit);

				$categoryNm = '신상품 30';

				$goodsCount = $goodsData['total'];

				App::render("Front/Goods/list", ['goodsList' => $goodsData['list'], 'categoryNm' => $categoryNm, 'pagination' => $goodsData['pagination'], 'goodsCount' => $goodsCount, 'category' => $category]);

			}else if($category == 'best'){ // best인 경우

				if($page > 5){ // 페이지를 일부러 5보다 크게 넣은 경우
					go("goods/list?category=best&page=5");
				}

				$goodsData = $goods->getBestGoods($page, $limit);

				$categoryNm = '베스트 30';

				$goodsCount = $goodsData['total'];

				App::render("Front/Goods/list", ['goodsList' => $goodsData['list'], 'categoryNm' => $categoryNm, 'pagination' => $goodsData['pagination'], 'goodsCount' => $goodsCount, 'category' => $category]);

			}else{ // 나머지

				// 만약 없는 카테고리면 이전 페이지로 가게 한다

				$categoryNm = $goods->getCategoryNm($category);
				
				if(!$categoryNm){ // 없는 카테고리일 경우
					alertBack('잘못된 접근입니다');
				}

				$goodsCount = $goods->getGoodsCountByCategory($category);

				// form 값 가져와서 sort에 따라 분기하기

				$sort = request()->get('sort_method');

				if(!$sort || $sort == 'new' || $sort == 'low_cost' || $sort == 'high_cost' || $sort == 'sell_point'){
					$goodsData = $goods->getGoodsByCategory($category, $page, $limit, $sort);

					$categoryNm = $goods->getCategoryNm($category);

					App::render("Front/Goods/list", ['goodsList' => $goodsData['list'], 'categoryNm' => $categoryNm, 'pagination' => $goodsData['pagination'], 'goodsCount' => $goodsCount, 'category' => $category, 'sort' => $sort]);
				}else{
					alertBack('잘못된 접근입니다');
				}
			}

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}