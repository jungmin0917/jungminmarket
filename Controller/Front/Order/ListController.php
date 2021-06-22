<?php

namespace Controller\Front\Order;

use App;
use Component\Exception\AlertException;

class ListController extends \Controller\Front\FrontController{
	public function __construct(){
		if(!isLogin()){
			alertReplace('로그인이 필요한 페이지입니다', "member/login");
		}
	}

	public function index(){
		try{
			$page = request()->get('page');

			$page = $page?$page:1;
			$limit = 3;

			$goods = App::load(\Component\Goods\Goods::class);

			$order = App::load(\Component\Order\Order::class);

			$memNo = getSession('member_memNo');

			$orderData = $order->getOrder($page, $limit, $memNo);

			foreach($orderData['list'] as $k => $v){
				$orderData['list'][$k]['orderGoodsList'] = $order->getOrderGoods($v['orderNo']);
			}

			App::render("Front/Order/list", ['orderList' => $orderData['list'], 'pagination' => $orderData['pagination']]);

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}