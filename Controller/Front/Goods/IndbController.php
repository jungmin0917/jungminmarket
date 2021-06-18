<?php

namespace Controller\Front\Goods;

use App;
use Component\Exception\AlertException;

class IndbController extends \Controller\Front\FrontController{
	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			$formData = request()->all();
			
			$goods = App::load(\Component\Goods\Goods::class);

			// 현재 사용자 정보 세션을 formData에 추가

			$formData['memNo'] = $_SESSION['member_memNo'];

			switch($formData['mode']){
				case 'buy_now':
					$formData['isDirect'] = 1;

					// 기존의 isDirect가 1인 목록 전부 삭제
					$result = $goods->deleteBuyNowCart();

					if($result === false){
						throw new AlertException('바로구매 내역 삭제 실패');
					}

					// 장바구니 DB 등록 처리
					$result = $goods->data($formData)->addCart();

					if($result === false){
						throw new AlertException('장바구니 추가 실패');
					}

					alertReplace("주문 페이지로 이동합니다", "order/order", "parent");

					break;

				case 'add_cart':

					// 먼저 장바구니에 넣기 DB 처리
					$formData['isDirect'] = 0;

					// 현재 로그인 한 사람의 장바구니 개수 5개 이상이면 등록 못 하게 하기
					$cartList = $goods->getCartList($formData['memNo']);

					if(count($cartList) >= 5){ // 해당 고객의 장바구니 개수 5개 이상일 때
						throw new AlertException('장바구니에는 최대 5개의 상품만 담을 수 있습니다');
					}

					$result = $goods->data($formData)->addCart();

					if($result === false){
						throw new AlertException('장바구니 추가 실패');
					}

					alertReplace("장바구니 추가에 성공했습니다. 장바구니 페이지로 이동합니다", "order/cart", "parent");

					break;

				case 'add_wishlist':

					break;
			}


		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}