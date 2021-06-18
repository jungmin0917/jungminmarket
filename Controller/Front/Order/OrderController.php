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

			switch($formData['mode']){ // 바로구매 버튼으로 넘어온 경우

				case 'buy_now':
					// 기존의 바로구매 목록 삭제
					debug($formData);
					exit;

					$result = $goods->deleteBuyNowCart();

					if($result === false){
						throw new AlertException('바로구매 목록 삭제 실패');
					}

					$formData['isDirect'] = 1;
					$formData['memNo'] = getSession('member_memNo');
					
					$result = $goods->data($formData)->addCart();

					if($result === false){
						throw new AlertException('바로구매 목록 등록 실패');
					}
					
					break;

				case 'order_all': // 장바구니 모든 상품 주문

					// cartNo -> 
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

					foreach($cartData as $k => $v){
						$totalPrice = $totalPrice + $v['goodsCount'] * $v['goodsData']['salePrice'];
					}

					App::render("Front/Order/order", ['memberData' => $memberData, 'cartData' => $cartData, 'totalPrice' => $totalPrice, 'deliveryFee' => $deliveryFee]);

					break;

				case 'order_select': // 선택 상품들 주문
					debug($formData);
					exit;

					break;

				case 'order_select_item': // 선택한 거 딱 하나 주문
					debug($formData);
					exit;

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