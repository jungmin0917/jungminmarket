<?php

namespace Controller\Front\Mypage;

use App;

class IndexController extends \Controller\Front\FrontController{

	public function index(){
		if(!isset($_SESSION['member']['memNo'])){
			alertGo('로그인이 필요한 페이지입니다', "member/login");
		}
		$memNo = $_SESSION['member']['memNo'];

		$member = App::load(\Component\Member\Member::class);

		$data = $member->getMember($memNo);

		App::render("Front/Mypage/index", $data);
	}
}