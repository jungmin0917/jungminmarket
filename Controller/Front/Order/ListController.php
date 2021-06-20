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
			$goods = App::load(\Component\Goods\Goods::class);

			$order = App::load(\Component\Order\Order::class);

			$memNo = getSession('member_memNo');

			$orderList = $order->getOrder($memNo);

			foreach($orderList as $k => $v){
				$orderList[$k]['orderGoodsList'] = $order->getOrderGoods($v['orderNo']);
			}

			App::render("Front/Order/list", ['orderList' => $orderList]);

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}