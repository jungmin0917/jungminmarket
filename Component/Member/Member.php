<?php

namespace Component\Member;

use App;
use PDO;
use Component\Exception\AlertException;

class Member{

	private $params = [];

	public function data($params = []){
		$this->params = $params;

		return $this;
	}

	public function validator($mode = null){
		switch($mode){
			case 'join':
				if(!$this->params['memId']){
					throw new AlertException('아이디를 입력해주세요');
				}
				if(!$this->params['memPw']){
					throw new AlertException('비밀번호를 입력해주세요');
				}
				if(!$this->params['memPwRe']){
					throw new AlertException('비밀번호 확인을 입력해주세요');
				}
				if(!$this->params['memNm']){
					throw new AlertException('이름을 입력해주세요');
				}
				if(!$this->params['memAdNum']){
					throw new AlertException('주소를 입력해주세요');
				}
				if(!$this->params['memAdMain']){
					throw new AlertException('주소를 입력해주세요');
				}
				if(!$this->params['memAdRemain']){
					throw new AlertException('나머지 주소를 입력해주세요');
				}
				for($i=0; $i<3; $i++){
					if(!$this->params['memPh'][$i]){
						throw new AlertException('전화번호를 입력해주세요');
					}	
				}
				if(!$this->params['memEm']){
					throw new AlertException('이메일을 입력해주세요');
				}

				$this->memIdValidate($this->params['memId']);
				$this->memPwValidate($this->params['memPw']);
				$this->memPwReValidate();
				$this->memNmValidate();
				$this->memAdRemainValidate();
				$this->memPhValidate();
				$this->memEmValidate();
				$this->agreeValidate();

				break;

			case 'register':
				if(!$this->params['memId']){
					throw new AlertException('아이디를 입력해주세요');
				}
				if(!$this->params['memPw']){
					throw new AlertException('비밀번호를 입력해주세요');
				}
				if(!$this->params['memPwRe']){
					throw new AlertException('비밀번호 확인을 입력해주세요');
				}
				if(!$this->params['memNm']){
					throw new AlertException('이름을 입력해주세요');
				}
				if(!$this->params['memAdNum']){
					throw new AlertException('주소를 입력해주세요');
				}
				if(!$this->params['memAdMain']){
					throw new AlertException('주소를 입력해주세요');
				}
				if(!$this->params['memAdRemain']){
					throw new AlertException('나머지 주소를 입력해주세요');
				}
				for($i=0; $i<3; $i++){
					if(!$this->params['memPh'][$i]){
						throw new AlertException('전화번호를 입력해주세요');
					}	
				}
				if(!$this->params['memEm']){
					throw new AlertException('이메일을 입력해주세요');
				}

				$this->memIdValidate($this->params['memId']);
				$this->memPwValidate($this->params['memPw']);
				$this->memPwReValidate();
				$this->memNmValidate();
				$this->memAdRemainValidate();
				$this->memPhValidate();
				$this->memEmValidate();

				break;

			case 'modify':
				if(!$this->params['memPw']){
					throw new AlertException('비밀번호를 입력해주세요');
				}
				if(!$this->params['memPwRe']){
					throw new AlertException('비밀번호 확인을 입력해주세요');
				}
				if(!$this->params['memNm']){
					throw new AlertException('이름을 입력해주세요');
				}
				if(!$this->params['memAdNum']){
					throw new AlertException('주소를 입력해주세요');
				}
				if(!$this->params['memAdMain']){
					throw new AlertException('주소를 입력해주세요');
				}
				if(!$this->params['memAdRemain']){
					throw new AlertException('나머지 주소를 입력해주세요');
				}
				for($i=0; $i<3; $i++){
					if(!$this->params['memPh'][$i]){
						throw new AlertException('전화번호를 입력해주세요');
					}	
				}
				if(!$this->params['memEm']){
					throw new AlertException('이메일을 입력해주세요');
				}

				$this->memPwValidate($this->params['memPw']);
				$this->memPwReValidate();
				$this->memNmValidate();
				$this->memAdRemainValidate();
				$this->memPhValidate();
				$this->memEmValidate();

				break;

			case 'login':
				if(!$this->params['memId']){
					throw new AlertException('아이디를 입력해주세요');
				}
				if(!$this->params['memPw']){
					throw new AlertException('비밀번호를 입력해주세요');
				}

				break;

			case 'findid':
				if(!$this->params['memNm']){
					throw new AlertException('이름을 입력해주세요');
				}

				if($this->params['find_method'] == 'email'){
					if(!$this->params['memEm']){
						throw new AlertException('이메일을 입력해주세요');
					}
				}else{
					if(!$this->params['memPh']){
						throw new AlertException('전화번호를 입력해주세요');
					}
				}

				break;

			case 'findpw':
				if(!$this->params['memId']){
					throw new AlertException('아이디를 입력해주세요');
				}

				if(!$this->params['memNm']){
					throw new AlertException('이름을 입력해주세요');
				}

				if(!$this->params['memEm']){
					throw new AlertException('이메일을 입력해주세요');
				}

				break;

			case 'changepw':
				if(!$this->params['memPw']){
					throw new AlertException('비밀번호를 입력해주세요');
				}
				if(!$this->params['memPwRe']){
					throw new AlertException('비밀번호 확인을 입력해주세요');
				}

				$this->memPwValidate($this->params['memPw']);
				$this->memPwReValidate();

				break;

			case 'terms':
				if(!$this->params['terms1']){
					throw new AlertException('약관 1을 입력해주세요');
				}

				if(!$this->params['terms2']){
					throw new AlertException('약관 2을 입력해주세요');
				}

				if(!$this->params['terms3']){
					throw new AlertException('약관 3을 입력해주세요');
				}

				break;

			case 'updateGrade':
				if(!isset($this->params['memNo'])){
					throw new AlertException('변경할 회원을 선택해주세요');
				}

				break;

			default:
				break;
		}

		return $this;
	}

	public function memIdValidate($memId){
		if(strlen($memId) < 4 || strlen($memId) > 16 || preg_match("/[^a-z0-9]/", $memId)){
			throw new AlertException('아이디는 4~16자의 영문소문자 및 숫자로 구성해주세요');
		}

		$sql = "SELECT COUNT(*) as cnt FROM jmmk_member WHERE memId = :memId";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":memId", $memId);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('아이디 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if($row['cnt'] > 0){
			throw new AlertException('이미 존재하는 아이디입니다');
		}
	}

	public function memPwValidate($memPw){
		if(strlen($memPw) < 8 || strlen($memPw) > 16 || !preg_match("/[a-z]/", $memPw) || !preg_match("/[A-Z]/", $memPw) || !preg_match("/[0-9]/", $memPw) || !preg_match("/[~!@#$%^&*()_+]/", $memPw)){
			throw new AlertException('비밀번호는 8~16자의 영문대소문자, 숫자, 특수문자를 포함해 입력해주세요');
		}
	}

	public function memPwReValidate(){
		if($this->params['memPw'] !== $this->params['memPwRe']){
			throw new AlertException('비밀번호 확인이 일치하지 않습니다');
		}
	}

	public function memNmValidate(){
		$memNm = $this->params['memNm'];

		$pattern = "/[^가-힣a-zA-Z]/";

		if(mb_strlen($memNm) < 2 || mb_strlen($memNm) > 8 || preg_match($pattern, $memNm)){
			throw new AlertException('이름은 특수문자를 제외하고 2~8자로 입력해주세요');
		}
	}

	public function memAdRemainValidate(){
		if(preg_match("/[^가-힣a-zA-Z0-9]/", $this->params['memNm'])){
			throw new AlertException('나머지 주소를 올바르게 입력해주세요');
		}
	}

	public function memPhValidate(){
		foreach($this->params['memPh'] as $v){
			if(preg_match("/[^0-9]/", $v)){
				throw new AlertException('전화번호를 올바르게 입력해주세요');
			}
		}

		if(strlen($this->params['memPh'][1]) < 3 || strlen($this->params['memPh'][1]) > 4){
			throw new AlertException('전화번호를 올바르게 입력해주세요');
		}

		if(strlen($this->params['memPh'][2]) != 4){
			throw new AlertException('전화번호를 올바르게 입력해주세요');
		}

		$memPh = implode("-", $this->params['memPh']);

		// 중복 체크
		$sql = "SELECT * FROM jmmk_member WHERE memPh = :memPh";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":memPh", $memPh);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('전화번호로 레코드 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if($row && $row['memId'] != $this->params['memId']){ // 정보 수정할 때는 빗겨가도록 하기
			throw new AlertException('이미 가입된 전화번호입니다');
		}
	}

	public function memEmValidate(){
		$memEm = $this->params['memEm'];

		$result = filter_var($memEm, FILTER_VALIDATE_EMAIL);

		if($result === false){
			throw new AlertException('이메일을 올바르게 입력해주세요');
		}

		// 중복 체크
		$sql = "SELECT * FROM jmmk_member WHERE memEm = :memEm";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":memEm", $memEm);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('이메일로 레코드 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if($row && $row['memId'] != $this->params['memId']){ // 정보 수정할 때는 빗겨가도록 하기
			throw new AlertException('이미 가입된 이메일입니다');
		}
	}

	public function agreeValidate(){
		if(!isset($this->params['agree_terms']) || !isset($this->params['agree_terms'][0]) || !isset($this->params['agree_terms'][1])){
			throw new AlertException('필수 약관에 동의해주세요');
		}
	}


	public function join(){
		$security = App::load(\Component\Core\Security::class);

		$memId = $this->params['memId'];
		$memPw = $security->createHash($this->params['memPw']);
		$memNm = $this->params['memNm'];
		$memAdNum = $this->params['memAdNum'];
		$memAdMain = $this->params['memAdMain'];
		$memAdRemain = $this->params['memAdRemain'];
		$memPhArray = $this->params['memPh'];
		$memEm = $this->params['memEm'];
		$memPh = implode("-", $memPhArray);

		$sql = "INSERT INTO jmmk_member (memId, memPw, memNm, memAdNum, memAdMain, memAdRemain, memPh, memEm) VALUES (:memId, :memPw, :memNm, :memAdNum, :memAdMain, :memAdRemain, :memPh, :memEm)";

		$stmt = db()->prepare($sql);

		$bindData = ['memId', 'memPw', 'memNm', 'memAdNum', 'memAdMain', 'memAdRemain', 'memPh', 'memEm'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('회원 가입 처리 실패');
		}

		return $result;
	}

	public function register(){
		$security = App::load(\Component\Core\Security::class);

		$memLv = 10;
		$memId = $this->params['memId'];
		$memPw = $security->createHash($this->params['memPw']);
		$memNm = $this->params['memNm'];
		$memAdNum = $this->params['memAdNum'];
		$memAdMain = $this->params['memAdMain'];
		$memAdRemain = $this->params['memAdRemain'];
		$memPhArray = $this->params['memPh'];
		$memEm = $this->params['memEm'];
		$memPh = implode("-", $memPhArray);

		$sql = "INSERT INTO jmmk_member (memLv, memId, memPw, memNm, memAdNum, memAdMain, memAdRemain, memPh, memEm) VALUES (:memLv, :memId, :memPw, :memNm, :memAdNum, :memAdMain, :memAdRemain, :memPh, :memEm)";

		$stmt = db()->prepare($sql);

		$bindData = ['memId', 'memPw', 'memNm', 'memAdNum', 'memAdMain', 'memAdRemain', 'memPh', 'memEm'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}
		$stmt->bindValue(":memLv", $memLv, PDO::PARAM_INT);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('회원 가입 처리 실패');
		}

		return $result;
	}

	public function modify(){
		$security = App::load(\Component\Core\Security::class);

		$memId = $this->params['memId']; // 아이디로 WHERE조건 걸어서 UPDATE SET 할 것임
		$memPw = $security->createHash($this->params['memPw']);
		$memNm = $this->params['memNm'];
		$memAdNum = $this->params['memAdNum'];
		$memAdMain = $this->params['memAdMain'];
		$memAdRemain = $this->params['memAdRemain'];
		$memPh = implode("-", $this->params['memPh']);
		$memEm = $this->params['memEm'];

		$sql = "UPDATE jmmk_member SET memPw = :memPw, memNm = :memNm, memAdNum = :memAdNum, memAdMain = :memAdMain, memAdRemain = :memAdRemain, memPh = :memPh, memEm = :memEm WHERE memId = :memId";

		$stmt = db()->prepare($sql);

		$bindData = ['memId', 'memPw', 'memNm', 'memAdNum', 'memAdMain', 'memAdRemain', 'memPh', 'memEm'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException("회원정보 수정 처리 실패");
		}

		return $result;
	}

	public function login(){
		$security = App::load(\Component\Core\Security::class);

		$memId = $this->params['memId'];
		$memPw = $this->params['memPw'];

		$sql = "SELECT COUNT(*) as cnt FROM jmmk_member WHERE memId = :memId";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":memId", $memId);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('아이디로 레코드 수 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if($row['cnt'] == 0){
			throw new AlertException('아이디 또는 비밀번호를 확인해주세요');
		}

		$sql = "SELECT * FROM jmmk_member WHERE memId = :memId";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":memId", $memId);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('아이디로 레코드 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$result = $security->compareHash($memPw, $row['memPw']);

		if($result === false){
			throw new AlertException('아이디 또는 비밀번호를 확인해주세요');
		}

		// 로그인 성공
		setSession('member_memNo', $row['memNo']);
		setSession('member_memId', $row['memId']);
		setSession('member_memNm', $row['memNm']);
		setSession('member_memLv', $row['memLv']);

		return $result;
	}

	public function adminLogin(){
		$security = App::load(\Component\Core\Security::class);

		$memId = $this->params['memId'];
		$memPw = $this->params['memPw'];

		$sql = "SELECT * FROM jmmk_member WHERE memId = :memId";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":memId", $memId);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('아이디로 레코드 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!$row){
			throw new AlertException('아이디, 비밀번호가 맞지 않거나 관리자가 아닙니다');
		}

		if($row['memLv'] != 10){
			throw new AlertException('아이디, 비밀번호가 맞지 않거나 관리자가 아닙니다');
		}

		$result = $security->compareHash($memPw, $row['memPw']);

		if($result === false){
			throw new AlertException('아이디, 비밀번호가 맞지 않거나 관리자가 아닙니다');
		}

		// 관리자 로그인 성공
		setSession('member_memNo', $row['memNo']);
		setSession('member_memId', $row['memId']);
		setSession('member_memNm', $row['memNm']);
		setSession('member_memLv', $row['memLv']);

		return $result;
	}

	public function getMember($memNo){
		$sql = "SELECT * FROM jmmk_member WHERE memNo = :memNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":memNo", $memNo);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('회원번호로 레코드 조회 실패');
		}

		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		return $data;
	}

	public function findid(){

		$memNm = $this->params['memNm'];
		$memEm = $this->params['memEm'];
		$memPhArray = $this->params['memPh'];

		$memPh = implode("-", $memPhArray);

		if($this->params['find_method'] == 'email'){ // 찾기 방법이 이메일인 경우
			$sql = "SELECT * FROM jmmk_member WHERE memNm = :memNm AND memEm = :memEm";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":memNm", $memNm);
			$stmt->bindValue(":memEm", $memEm);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('이름, 이메일로 레코드 조회 실패');
			}

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			if(!$row){
				throw new AlertException('입력한 정보로 가입한 아이디가 없습니다');
			}

			// 성공한 경우
			$token = md5(uniqid($row['memNo']));

			setSession('findid', $token, 10); // URL용
			setSession('findidmemNo', $row['memNo'], 10); // 데이터 찾기용

			return $token;

		}else{ // 찾기 방법이 전화번호인 경우

			$sql = "SELECT * FROM jmmk_member WHERE memNm = :memNm AND memPh = :memPh";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":memNm", $memNm);
			$stmt->bindValue(":memPh", $memPh);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('이름, 전화번호로 레코드 조회 실패');
			}

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			if(!$row){
				throw new AlertException('입력한 정보로 가입한 아이디가 없습니다');
			}

			// 성공한 경우
			$token = md5(uniqid($row['memNo']));

			setSession('findid', $token, 10); // URL용
			setSession('findidmemNo', $row['memNo'], 10); // 데이터 찾기용

			return $token;
		}
	}

	public function findpw(){
		$memId = $this->params['memId'];
		$memNm = $this->params['memNm'];
		$memEm = $this->params['memEm'];

		$sql = "SELECT * FROM jmmk_member WHERE memId = :memId AND memNm = :memNm AND memEm = :memEm";

		$stmt = db()->prepare($sql);

		$bindData = ['memId', 'memNm', 'memEm'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('레코드 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!$row){
			throw new AlertException('입력한 정보로 가입한 아이디가 없습니다');
		}

		// 성공한 경우
		$resultpw_token = md5(uniqid($row['memNo']));
		setSession('findpw', $resultpw_token, 10); // URL용
		setSession('findpwmemNo', $row['memNo'], 10); // 데이터 찾기용

		// 해당 토큰은 DB 이용해야 함 (새 창으로 열면 브라우저가 바뀌어서 작동 안 함)
		// 시간 표시하고 인증번호 보내라는 식도 가능할 듯
		$changepw_token = md5(uniqid($row['memNo']));
		setSession('changepw', $changepw_token, 300); // changepw 접근 URL용
		setSession('changepwmemNo', $row['memNo'], 300); // changepw 데이터 찾기용

		return [
			'memNo' => $row['memNo'],
			'resultpw_token' => $resultpw_token,
			'changepw_token' => $changepw_token,
		];
	}

	public function changepw(){
		$security = App::load(\Component\Core\Security::class);
		$memPw = $security->createHash($this->params['memPw']);
		$memNo = getSession('changepwmemNo');

		$sql = "UPDATE jmmk_member SET memPw = :memPw WHERE memNo = :memNo";

		$stmt = db()->prepare($sql);

		$bindData = ['memPw', 'memNo'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('비밀번호 변경 DB 처리 실패');
		}

		return $result;
	}

	public function termsUpdate(){
		$terms1 = $this->params['terms1'];
		$terms2 = $this->params['terms2'];
		$terms3 = $this->params['terms3'];

		$sql = "UPDATE jmmk_member_terms SET terms1 = :terms1, terms2 = :terms2, terms3 = :terms3 WHERE termsNo = :termsNo";

		$stmt = db()->prepare($sql);

		$bindData = ['terms1', 'terms2', 'terms3'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}
		$stmt->bindValue(":termsNo", 1, PDO::PARAM_INT);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('약관 업데이트 실패');
		}

		return $result;
	}

	public function getTerms(){
		$sql = "SELECT * FROM jmmk_member_terms WHERE termsNo = :termsNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":termsNo", 1, PDO::PARAM_INT);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('약관 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row;
	}

	public function getList($page = 1, $limit){
		try{
			$url = siteUrl("admin/member/list");
			$page = $page?$page:1; // 기본값 1
			$limit = $limit?$limit:10; // 기본값 10
			$offset = ($page - 1) * $limit; // 각 페이지 시작 레코드

			// total 구하기
			$sql = "SELECT COUNT(*) as cnt FROM jmmk_member";

			$stmt = db()->prepare($sql);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('총 레코드 수 조회 실패');
			}

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$total = $row['cnt'];

			// list 구하기
			$sql = "SELECT * FROM jmmk_member ORDER BY regDt DESC LIMIT :limit OFFSET :offset";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
			$stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('리스트 조회 실패');
			}

			$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// 페이징하기
			$paginator = App::load(\Component\Core\Pagination::class, $page, $limit, $total, $url);

			$pagination = $paginator->getHTML();

			$data = [
				'list' => $list,
				'pagination' => $pagination,
			];

			return $data;

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	public function updateGrade(){
		$checked = $this->params['memNo'];
		$data = $this->params['memLv'];

		foreach($checked as $k => $v){
			$checked_memNo = $k;

			foreach($data as $k => $v){ // $k는 memNo이고, $v는 memLv로 치환하여 SQL UPDATE 한다
				$memNo = $k;
				$memLv = $v;

				if($checked_memNo == $k){
					$sql = "UPDATE jmmk_member SET memLv = :memLv WHERE memNo = :memNo";

					$stmt = db()->prepare($sql);

					$bindData = ['memLv', 'memNo'];

					foreach($bindData as $v){
						$stmt->bindValue(":{$v}", $$v);
					}

					$result = $stmt->execute();

					if($result === false){
						throw new AlertException('회원등급 변경 DB 처리 실패');
					}
				}
			}
		}

		return $result;
	}
}