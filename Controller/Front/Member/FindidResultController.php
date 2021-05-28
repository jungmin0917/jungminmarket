<?php

namespace Controller\Front\Member;

use App;

class FindidResultController extends \Controller\Front\FrontController{
	public function __construct(){
		$result = getSession('findid');

		$token = request()->get('member');

		if(!$result || $result != $token){
			alertGo('잘못된 접근입니다. 메인 페이지로 돌아갑니다', "");
		}
	}

	public function index(){
		$member = App::load(\Component\Member\Member::class);

		$memNo = getSession('findidmemNo');

		$data = $member->getMember($memNo);

		App::render("Front/Member/findidresult", $data);
	}
}