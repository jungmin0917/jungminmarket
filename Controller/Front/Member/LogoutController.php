<?php

namespace Controller\Front\Member;

use App;

class LogoutController extends \Controller\Front\FrontController{
	public function __construct(){
		$this->layoutBlank = true;
		if(!isLogin()){
			alertBack("이미 로그아웃했습니다. 이전 페이지로 돌아갑니다");
		}
	}

	public function index(){
		setSession('member_memNo', '');
		setSession('member_memId', '');
		setSession('member_memNm', '');
		setSession('member_memLv', '');

		alertGo("로그아웃했습니다. 메인 페이지로 돌아갑니다", "");
	}
}