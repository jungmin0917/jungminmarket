<?php

namespace Controller\Admin\Member;

use App;

class LoginController extends \Controller\Admin\AdminController{

	public function __construct(){
		if(isset($_SESSION['member']['memNo']) && $_SESSION['member']['memLv'] != 10){
			alertGo('일반회원으로 로그인 한 상태입니다. 로그아웃 후 접근해주세요', "");
		}else if(isset($_SESSION['member']['memNo'])){ // 관리자로 로그인 한 상태
			alertGo('이미 로그인하셨습니다. 메인 페이지로 이동합니다', "admin");
		}
	}

	public function isAdmin(){
		return;
	}

	public function topMenu(){
		return;
	}

	public function index(){
		App::render("Admin/Member/login");
	}
}