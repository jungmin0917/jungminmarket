<?php

namespace Controller\Front\Order;

use App;
use Component\Exception\AlertException;

class OrderController extends \Controller\Front\FrontController{

	public function __construct(){
		if(!isLogin()){
			alertReplace('로그인이 필요한 페이지입니다', "member/login");
		}
	}

	public function index(){
		try{
			$formData = request()->all();

			$goods = App::load(\Component\Goods\Goods::class);

			$member = App::load(\Component\Member\Member::class);

			if(!$formData){ // 폼 데이터 없이 그냥 url로 접근했을 경우
				alertBack('잘못된 접근입니다');
			}

			switch($formData['mode']){

				case 'buy_now': // 바로구매로 넘어온 경우
					// 기존의 바로구매 목록 삭제

					$memNo = getSession('member_memNo');
					$result = $goods->deleteBuyNowCart($memNo);

					if($result === false){
						throw new AlertException('바로구매 목록 삭제 실패');
					}

					$formData['isDirect'] = 1;
					$formData['memNo'] = getSession('member_memNo');
					
					$result = $goods->data($formData)->addCart();

					if($result === false){
						throw new AlertException('바로구매 목록 등록 실패');
					}

					// isDirect가 1인 Cart는 1개이기 때문에 그것으로 cartNo를 접근하여 만든다
					// 단, 1개의 memNo당 1개이기 때문에 주의한다

					$cartNo = $goods->getisDirectCart($memNo);

					$formData['cartNo'][0] = $cartNo;

					// 여기서부턴 아래와 같이 하면 된다

					$cartData = [];
					foreach($formData['cartNo'] as $k => $v){
						$cartData[$v] = $goods->getCart($v);
					}

					foreach($cartData as $k => $v){
						$cartData[$k]['goodsData'] = $goods->getGoods($v['goodsNo']);
					}

					$memberData = $member->getMember($memNo);

					$deliveryFee = 3000;
					$totalPrice = 0;
					$memPhArray = explode('-', $memberData['memPh']);

					foreach($cartData as $k => $v){
						$totalPrice = $totalPrice + $v['goodsCount'] * $v['goodsData']['salePrice'];
					}

					App::render("Front/Order/order", ['memberData' => $memberData, 'cartData' => $cartData, 'totalPrice' => $totalPrice, 'deliveryFee' => $deliveryFee, 'memPhArray' => $memPhArray]);
					
					break;

				case 'order_all': // 장바구니 모든 상품 주문
				case 'order_select': // 선택한 것들만 주문
				case 'order_select_item': // 주문하기 버튼으로 하나만 선택 주문

					if(!isset($formData['cartNo'])){
						alertReplace('선택된 상품이 없습니다', 'order/cart');
					}

					$cartData = [];
					foreach($formData['cartNo'] as $k => $v){
						$cartData[$v] = $goods->getCart($v);
					}

					foreach($cartData as $k => $v){
						$cartData[$k]['goodsData'] = $goods->getGoods($v['goodsNo']);
					}

					// memberData 구하기
					$memNo = getSession('member_memNo');

					$memberData = $member->getMember($memNo);

					$deliveryFee = 3000;
					$totalPrice = 0;
					$memPhArray = explode('-', $memberData['memPh']);

					foreach($cartData as $k => $v){
						$totalPrice = $totalPrice + $v['goodsCount'] * $v['goodsData']['salePrice'];
					}

					App::render("Front/Order/order", ['memberData' => $memberData, 'cartData' => $cartData, 'totalPrice' => $totalPrice, 'deliveryFee' => $deliveryFee, 'memPhArray' => $memPhArray]);

					break;

				default:
					break;
			}

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}