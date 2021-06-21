<?php

namespace Controller\Front\Order;

use App;
use Component\Exception\AlertException;

class ViewController extends \Controller\Front\FrontController{
	public function __construct(){
		if(!isLogin()){
			alertReplace('로그인이 필요한 페이지입니다', "member/login");
		}

		// 해당 주문번호의 주문이 해당 회원의 것인지 확인해야 한다.

		$memNo = getSession('member_memNo');

		$orderNo = request()->get('orderNo');

		$order = App::load(\Component\Order\Order::class);

		$result = $order->isOrderOwn($orderNo, $memNo);

		if($result === false){
			alertBack('잘못된 접근입니다');
		}
	}

	public function index(){
		try{
			$memNo = getSession('member_memNo');

			$orderNo = request()->get('orderNo');

			$order = App::load(\Component\Order\Order::class);

			$goods = App::load(\Component\Goods\Goods::class);

			$orderData = $order->getOrderData($orderNo);

			$orderGoods = $order->getOrderGoods($orderNo);

			$deliveryFee = 3000;

			$totalPrice = $order->getOrderTotalPrice($orderNo);
		
			App::render("Front/Order/view", ['orderData' => $orderData, 'orderGoods' => $orderGoods, 'deliveryFee' => $deliveryFee, 'totalPrice' => $totalPrice]);

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}