<?php

namespace Controller\Front\Mypage;

use App;

class IndexController extends \Controller\Front\FrontController{

	public function __construct(){
		if(!isLogin()){
			alertGo('로그인이 필요한 페이지입니다', "member/login");
		}
	}

	public function index(){
		
		$memNo = getSession('member_memNo');

		$member = App::load(\Component\Member\Member::class);

		$data = $member->getMember($memNo);

		App::render("Front/Mypage/index", $data);
	}
}