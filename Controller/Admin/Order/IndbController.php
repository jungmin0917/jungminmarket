<?php

namespace Controller\Admin\Order;

use App;
use Component\Exception\AlertException;

class IndbController extends \Controller\Admin\AdminController{

	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			$formData = request()->all();

			$order = App::load(\Component\Order\Order::class);

			switch($formData['mode']){
				case 'update':

					$result = $order->data($formData)->updateOrderStatus();

					if($result === false){
						throw new AlertException('주문상태 업데이트 실패');
					}

					alertReload('주문상태 업데이트에 성공했습니다', 'parent');

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