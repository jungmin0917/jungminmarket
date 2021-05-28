<?php

namespace Controller\Front\Member;

use App;

class FindpwResultController extends \Controller\Front\FrontController{
	public function __construct(){
		$findpw = getSession('findpw');

		$token = request()->get('member');

		if(!$findpw || $findpw != $token){
			alertGo('잘못된 접근입니다. 메인 페이지로 돌아갑니다', "");
		}
	}

	public function index(){
		$member = App::load(\Component\Member\Member::class);

		$memNo = getSession('findpwmemNo');

		$data = $member->getMember($memNo);

		App::render("Front/Member/findpwresult", $data);
	}
}