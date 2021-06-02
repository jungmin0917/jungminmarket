<?php

namespace Controller\Front\Member;

use App;

class JoinController extends \Controller\Front\FrontController{

	public function __construct(){
		if(isLogin()){
			alertBack("이미 로그인했습니다. 이전 페이지로 돌아갑니다");
		}
	}

	public function index(){

		$member = App::load(\Component\Member\Member::class);

		$data = $member->getTerms();

		App::render("Front/Member/join", $data);
	}
}