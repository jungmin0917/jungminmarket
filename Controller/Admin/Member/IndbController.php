<?php

namespace Controller\Admin\Member;

use App;
use Component\Exception\AlertException;

class IndbController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->layoutBlank = true;
	}

	public function isAdmin(){
		return;
	}

	public function index(){
		try{
			$formData = request()->all();

			$member = App::load(\Component\Member\Member::class);

			switch($formData['mode']){
				case 'login':

					$result = $member->data($formData)->validator('login')->adminLogin();

					if($result === false){
						throw new AlertException('관리자 로그인 실패');
					}

					alertReplace('관리자 로그인에 성공했습니다. 메인 페이지로 이동합니다', "admin", "parent");

					break;

				case 'terms':
					$result = $member->data($formData)->validator('terms')->termsUpdate();

					if($result === false){
						throw new AlertException('약관 업데이트 실패');
					}

					alertReplace('회원가입 약관 업데이트에 성공했습니다', "admin/member/config", "parent");;

					break;

				case 'updateGrade':

					$result = $member->data($formData)->updateGrade();

					if($result === false){
						throw new AlertException('회원등급 일괄 변경 실패');
					}

					alertReload('회원등급 일괄 변경에 성공했습니다', "parent");

					break;

				case 'register':

					$result = $member->data($formData)->validator('register')->register();

					if($result === false){
						throw new AlertException('관리자 등록 실패');
					}

					alertReplace('관리자 등록에 성공했습니다', "admin/member/list", "parent");

					break;
			}
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}