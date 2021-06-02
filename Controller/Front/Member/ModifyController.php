<?php

namespace Controller\Front\Member;

use App;
use Component\Exception\AlertException;

class ModifyController extends \Controller\Front\FrontController{
	public function index(){
		try{
			if(!isLogin()){
				alertGo("로그인을 먼저 해주세요. 로그인 페이지로 이동합니다", "member/login");
			}

			$member = App::load(\Component\Member\Member::class);

			$memNo = getSession('member_memNo');

			$data = $member->getMember($memNo);
			
			App::render("Front/Member/join", $data);
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}