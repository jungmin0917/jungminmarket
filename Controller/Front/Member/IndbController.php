<?php

namespace Controller\Front\Member;

use App;
use Component\Exception\AlertException;

class IndbController extends \Controller\Front\FrontController{
	public function __construct(){
		$this->layoutBlank = 'true';
	}

	public function index(){
		try{
			$formData = request()->all();
			
			if(!$formData){
				alertBack('잘못된 접근입니다. 이전 페이지로 이동합니다');
			}

			$member = App::load(\Component\Member\Member::class);

			switch($formData['mode']){
				case 'join':
					$result = $member->data($formData)->validator('join')->join();

					if($result === false){
						throw new AlertException('회원가입 실패');
					}

					alertReplace('회원가입에 성공했습니다. 로그인 페이지로 이동합니다', "member/login", "parent");

					break;

				case 'modify':
					if($formData['memId'] != getSession('member_memId')){
						throw new AlertException('잘못된 접근입니다. 페이지를 새로고침하여 진행해주세요.');
					}

					$result = $member->data($formData)->validator('modify')->modify();

					if($result === false){
						throw new AlertException('회원정보 수정 실패');
					}

					alertReplace('회원정보 수정에 성공했습니다. 메인 페이지로 이동합니다', "", "parent");

					break;

				case 'login':
					$result = $member->data($formData)->validator('login')->login();

					if($result === false){
						throw new AlertException('로그인 실패');
					}

					alertReplace('로그인에 성공했습니다. 메인 페이지로 이동합니다', "", "parent");

					break;

				case 'findid':
					// $result 값으로 회원 아이디 받기
					$result = $member->data($formData)->validator('findid')->findid();

					if($result === false){
						throw new AlertException('아이디 찾기 실패');
					}

					alertReplace('아이디 찾기에 성공했습니다. 결과 페이지로 이동합니다', "member/findidResult?member=".$result, "parent");

					break;

				case 'findpw':
					$result = $member->data($formData)->validator('findpw')->findpw();

					if($result === false){
						throw new AlertException('비밀번호 찾기 실패');
					}

					// 메일 보내는데에 필요한 정보 정리

					$memberData = $member->getMember($result['memNo']);

					$email = $memberData['memEm'];
					$memNm = $memberData['memNm'];

					// 메일 보내기
					$to = $email;
					$subject = "[정민마켓] 비밀번호 재설정 메일";
					$contents = "
	안녕하세요. {$memNm}님.
	비밀번호 재설정을 위한 URL을 보내드립니다.
	http://jungmin0917.cafe24.com/workspace/jungminmarket/member/changepw?member={$result['changepw_token']}
	저희 정민마켓을 이용해주셔서 항상 감사드립니다.
					";
					$headers = "From: cloond_@naver.com";

					mail($to, $subject, $contents, $headers);

					alertReplace('비밀번호 찾기에 성공했습니다. 결과 페이지로 이동합니다', "member/findpwResult?member=".$result['resultpw_token'], "parent");

					break;

				case 'changepw':
					$token = getSession('changepw');

					if($formData['token'] != $token){
						throw new AlertException('잘못된 접근입니다. 페이지를 새로고침하여 진행해주세요.');
					}

					$result = $member->data($formData)->validator('changepw')->changepw();

					if($result === false){
						throw new AlertException('비밀번호 변경 실패');
					}

					alertReplace('비밀번호 변경에 성공했습니다. 로그인 페이지로 이동합니다', "member/login", "parent");

					break;

				default :
					break;
			}
			
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}