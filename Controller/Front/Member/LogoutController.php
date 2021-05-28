<?php

namespace Controller\Front\Member;

use App;

class LogoutController extends \Controller\Front\FrontController{
	public function __construct(){
		$this->layoutBlank = true;
		if(!isset($_SESSION['member']['memNo'])){
			alertBack("이미 로그아웃했습니다. 이전 페이지로 돌아갑니다");
		}
	}

	public function index(){
		$_SESSION['member'] = []; // member 세션 초기화

		alertGo("로그아웃했습니다. 메인 페이지로 돌아갑니다", "");
	}
}