<?php

namespace Controller\Admin\Member;

use App;
use Component\Exception\AlertException;

class AjaxController extends \Controller\Admin\AdminController{

	public function __construct(){
		$this->layoutBlank = true;

		header("Content-Type: application; charset=utf-8");
	}

	public function index(){
		try{
			$formData = request()->all();

			$member = App::load(\Component\Member\Member::class);

			switch($formData['mode']){
				// 회원가입 유효성 검사

				case "register" :
					$msg = '';
					$isPass = true; // 기본은 통과, 유효성 검사 실패시 false로 변경
					$len = strlen($formData['value']);

					switch($formData['column']){
						/** 아이디 유효성 검사 */
						case 'memId' :
							$msg = "사용 가능한 아이디입니다";
							$member->memIdValidate($formData['value']);
							break;

						/** 비밀번호 유효성 검사 */
						case 'memPw' :
							$msg = "사용 가능한 비밀번호입니다";
							$member->memPwValidate($formData['value']);
							break;
					}

					$data = [
						'isPass' => true,
						'message' => $msg,
					];
					echo json_encode($data);

					break;
			}
		}catch(AlertException $e){
			$data = [
				'isPass' => false,
				'message' => $e->getMessage(),
			];
			echo json_encode($data);
			exit;
		}
	}
}