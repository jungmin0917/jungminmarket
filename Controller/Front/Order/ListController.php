<?php

namespace Controller\Front\Order;

use App;
use Component\Exception\AlertException;

class ListController extends \Controller\Front\FrontController{
	public function __construct(){
		if(!isLogin()){
			alertReplace('로그인이 필요한 페이지입니다', "member/login");
		}
	}

	public function index(){
		
	}
}