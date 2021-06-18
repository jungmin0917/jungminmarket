<?php

namespace Controller\Front\Goods;

use App;
use Component\Exception\AlertException;

class UpdateCartController extends \Controller\Front\FrontController{
	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			$formData = request()->post();

			$goods = App::load(\Component\Goods\Goods::class);

			$result = $goods->data($formData)->updateCart();

			if($result === false){
				throw new AlertException ('장바구니 업데이트 실패');
			}

			echo 1; // 성공 시

		}catch(AlertException $e){
			echo 0;
			exit;
		}
	}
}