<?php

namespace Controller\Front\Member;

use App;

class ChangepwController extends \Controller\Front\FrontController{
	public function __construct(){
		$changepw = getSession('changepw');

		$token = request()->get('member');

		if(!$changepw || $changepw != $token){
			alertGo('잘못된 접근입니다. 메인 페이지로 돌아갑니다', "");
		}
	}

	public function index(){
		$member = App::load(\Component\Member\Member::class);

		$token = getSession('changepw'); // 인증용

		App::render("Front/Member/changepw", ['token' => $token]);
	}
}