<?php

namespace Controller\Front\Goods;

use App;
use Component\Exception\AlertException;

class ViewController extends \Controller\Front\FrontController{

	public function index(){
		try{
			$goods = App::load(\Component\Goods\Goods::class);

			$goodsNo = request()->get('goodsNo');

			$goodsData = $goods->getGoods($goodsNo);

			App::render("Front/Goods/view", ['goodsData' => $goodsData]);

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}