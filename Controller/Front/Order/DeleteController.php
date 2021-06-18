<?php

namespace Controller\Front\Order;

use App;
use Component\Exception\AlertException;

class DeleteController extends \Controller\Front\FrontController{

	public function __construct(){
		if(!isLogin()){
			alertReplace('로그인이 필요한 페이지입니다', "member/login");
		}
		
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			$goods = App::load(\Component\Goods\Goods::class);

			$cartNo = request()->get('cartNo');

			$result = $goods->deleteCart($cartNo);

			if($result === false){
				throw new AlertException('장바구니 상품 삭제 실패');
			}

			alertReplace('장바구니 상품 삭제에 성공했습니다', 'order/cart');

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}