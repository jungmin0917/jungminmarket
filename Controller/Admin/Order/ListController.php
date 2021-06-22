<?php

namespace Controller\Admin\Order;

use App;
use Component\Exception\AlertException;

class ListController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'order';
		$this->subMenuCode = 'order_list';
	}

	public function subMenu(){
		App::render("Admin/Menus/orderMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){
		try{
			$order = App::load(\Component\Order\Order::class);

			$goods = App::load(\Component\Goods\Goods::class);

			$page = request()->get('page');

			$page = $page?$page:1;
			$limit = 5;

			$orderData = $order->getOrderList($page, $limit);

			foreach($orderData['list'] as $k => $v){
				$orderData['list'][$k]['goodsData'] = $order->getOrderGoods($v['orderNo']);
			}

			App::render("Admin/Order/list", ['orderList' => $orderData['list'], 'pagination' => $orderData['pagination']]);

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}