<?php

namespace Controller\Admin\Member;

use App;

class LoginController extends \Controller\Admin\AdminController{

	public function isAdmin(){
		return;
	}

	public function __construct(){
		if(isLogin() && !isAdminLogin()){
			alertGo('일반회원으로 로그인 한 상태입니다. 로그아웃 후 접근해주세요', "");
		}else if(isAdminLogin()){ // 관리자로 로그인 한 상태
			alertGo('이미 로그인하셨습니다. 메인 페이지로 이동합니다', "admin");
		}
	}

	public function topMenu(){
		return;
	}

	public function index(){
		App::render("Admin/Member/login");
	}
}