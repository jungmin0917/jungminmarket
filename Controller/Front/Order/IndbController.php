<?php

namespace Controller\Front\Order;

use App;

class IndbController extends \Controller\Front\FrontController{
	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			$formData = request()->all();

			$goods = App::load(\Component\Goods\Goods::class);

			switch($formData['mode']){
				case 'remove_all':

					$memNo = $_SESSION['member_memNo'];

					$result = $goods->deleteCartAll($memNo);

					if($result === false){
						throw new AlertException('장바구니 비우기 실패');
					}

					alertReload('장바구니 비우기에 성공했습니다', 'parent');

					break;

				case 'remove_select':

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