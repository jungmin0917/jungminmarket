<?php

namespace Controller\Front\Order;

use App;
use Component\Exception\AlertException;

class IndbController extends \Controller\Front\FrontController{
	public function __construct(){
		if(!isLogin()){
			alertReplace('로그인이 필요한 페이지입니다', "member/login", "parent");
		}
		
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			$formData = request()->all();

			$goods = App::load(\Component\Goods\Goods::class);

			$order = App::load(\Component\Order\Order::class);

			switch($formData['mode']){

				case 'order':

					$result = $order->data($formData)->validator('order')->order();

					if($result === false){
						throw new AlertException('주문에 실패했습니다');
					}

					alertReplace('주문에 성공했습니다. 주문내역 페이지로 이동합니다', 'order/list', 'parent');

					break;

				case 'remove_all':

					if(!isset($formData['cartNo'])){
						alertReplace('선택된 상품이 없습니다', 'order/cart');
					}

					$memNo = $_SESSION['member_memNo'];

					$result = $goods->deleteCartAll($memNo);

					if($result === false){
						throw new AlertException('장바구니 비우기 실패');
					}

					alertReload('장바구니 비우기에 성공했습니다', 'parent');

					break;

				case 'remove_select':

					if(!isset($formData['cartNo'])){
						alertReplace('선택된 상품이 없습니다', 'order/cart');
					}

					// v 값이 cartNo 값임을 이용하여 순회하여 제거
				
					foreach($formData['cartNo'] as $k => $v){
						$result = $goods->deleteCart($v);

						if($result === false){
							throw new AlertException('장바구니 선택 상품 삭제 실패');
						}
					}

					alertReload('선택 상품 삭제에 성공했습니다', 'parent');

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