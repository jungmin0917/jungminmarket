<?php

namespace Controller\Front\Order;

use App;
use Component\Exception\AlertException;

class CartController extends \Controller\Front\FrontController{
	public function __construct(){
		if(!isLogin()){
			alertReplace('로그인이 필요한 페이지입니다', "member/login");
		}
	}
	
	public function index(){
		try{
			$goods = App::load(\Component\Goods\Goods::class);

			$memNo = $_SESSION['member_memNo'];

			$cartList = $goods->getCartList($memNo);

			App::render("Front/Order/cart", ['cartList' => $cartList]);
			
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}