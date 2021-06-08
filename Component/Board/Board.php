<?php

namespace Component\Board;

use App;
use PDO;
use Component\Exception\AlertException;

class Board{

	private $params = [];

	public function data($params = []){
		$this->params = $params;
		return $this;
	}

	public function validator($mode = null){
		switch($mode){
			case 'create':
				if(!$this->params['boardId']){
					throw new AlertException('게시판 아이디를 입력해주세요');
				}

				if(!$this->params['boardNm']){
					throw new AlertException('게시판 이름을 입력해주세요');
				}

				if(!$this->params['category']){
					throw new AlertException('카테고리를 1개 이상 입력해주세요');
				}

				$this->boardIdValidate();

				break;

			case 'updateNameSkin':
				if(!isset($this->params['boardNo'])){
					throw new AlertException('변경할 게시판을 선택해주세요');
				}

				foreach($this->params['boardNm'] as $v){
					if(!$v){
						throw new AlertException('게시판 이름을 입력해주세요');
					}
				}

				break;

			case 'write':
				if(!$this->params['subject']){
					throw new AlertException('제목을 입력해주세요');
				}

				if(strlen($this->params['subject']) > 100){
					throw new AlertException('제목이 너무 길어요');
				}

				if(!$this->params['contents']){
					throw new AlertException('내용을 입력해주세요');
				}
				break;

			case 'modify':
				if(!$this->params['subject']){
					throw new AlertException('제목을 입력해주세요');
				}

				if(strlen($this->params['subject']) > 100){
					throw new AlertException('제목이 너무 길어요');
				}

				if(!$this->params['contents']){
					throw new AlertException('내용을 입력해주세요');
				}
				break;

			default:
				break;
		}
		return $this;
	}

	public function boardIdValidate(){
		$boardId = $this->params['boardId'];

		if(preg_match("/[^a-z_]/", $boardId) || strlen($boardId) < 2 || strlen($boardId) > 16){
			throw new AlertException('게시판 아이디는 영문 소문자 및 언더바 포함 2~16자로 입력해주세요');
		}

		// 중복 검사
		$sql = "SELECT COUNT(*) as cnt FROM jmmk_board_create WHERE boardId = :boardId";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":boardId", $boardId);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('게시판 아이디로 DB 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if($row['cnt'] > 0){
			throw new AlertException('이미 존재하는 게시판 아이디입니다');
		}
	}

	public function create(){
		$boardId = $this->params['boardId'];
		$boardNm = $this->params['boardNm'];
		$category = $this->params['category'];
		$boardSkin = $this->params['boardSkin'];

		// *카테고리는 PHP_EOL(\r\n)으로 구분한다. PHP_EOL 이용하여 정제해서 사용하면 된다.

		// 일단 배열로 나눠서 유효성 검사
		$categories = explode(PHP_EOL, $category);

		foreach($categories as $v){
			if(empty($v)){ // 빈칸인 카테고리가 있을 경우
				throw new AlertException('카테고리를 제대로 입력해주세요');
			}
		}

		// 다시 넣을 때 문자로 조합
		$category = implode(PHP_EOL, $categories);

		$sql = "INSERT INTO jmmk_board_create (boardId, boardNm, category, boardSkin) VALUES (:boardId, :boardNm, :category, :boardSkin)";

		$stmt = db()->prepare($sql);

		$bindData = ['boardId', 'boardNm', 'category', 'boardSkin'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('게시판 생성 DB 처리 실패');
		}

		return $result;
	}

	public function updateNameSkin(){
		$checked_boardNo = $this->params['boardNo'];
		$boardNmList = $this->params['boardNm'];
		$boardSkinList = $this->params['boardSkin'];

		foreach($checked_boardNo as $checked_k => $checked_v){

			foreach($boardNmList as $k => $v){

				if($checked_k == $k){
					$sql = "UPDATE jmmk_board_create SET boardNm = :boardNm WHERE boardNo = :boardNo";

					$stmt = db()->prepare($sql);

					$stmt->bindValue(":boardNm", $v);
					$stmt->bindValue(":boardNo", $k);

					$result = $stmt->execute();

					if($result === false){
						throw new AlertException('게시판 이름 변경 실패');
					}
				}
			}

			foreach($boardSkinList as $k => $v){

				if($checked_k == $k){
					$sql = "UPDATE jmmk_board_create SET boardSkin = :boardSkin WHERE boardNo = :boardNo";

					$stmt = db()->prepare($sql);

					$stmt->bindValue(":boardSkin", $v);
					$stmt->bindValue(":boardNo", $k);

					$result = $stmt->execute();

					if($result === false){
						throw new AlertException('게시판 스킨 변경 실패');
					}
				}
			}

		}
		return $result;
	}

	// 게시판 스킨 목록 로딩
	public function getSkins(){
		$skins = [];
		$skins[] = "Default"; // 먼저 로딩해야 함
		$path = __DIR__ . "/../../Views/Front/Board/Skins";

		$fileList = glob($path."/*");

		foreach($fileList as $file){
			if(is_dir($file)){ // Skins 경로 하나 아래에 있는 것이 폴더일 때
				$array = explode("/", $file); // 해당 경로를 분해하여 array로
				$skins[] = $array[count($array) - 1]; // 맨 뒤의 경로(즉, 파일명)를 skins array에 넣음
			}
		}

		$skins = array_unique($skins);
		return $skins; // 해당 파일 리스트를 반환
	}

	// 게시판 스킨 설정 가져오기
	public function getSkin($boardId){
		$sql = "SELECT * FROM jmmk_board_create WHERE boardId = :boardId";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":boardId", $boardId);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('게시판 아이디로 레코드 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row['boardSkin'];
	}

	// 게시판 리스트 (게시글 리스트 아님)
	public function getBoardList($page = 1, $limit = 10){
		try{
			$url = siteUrl("admin/board/list");
			$page = $page?$page:1; // 기본값 1
			$limit = $limit?$limit:10; // 기본값 10
			$offset = ($page - 1) * $limit; // 각 페이지 시작 레코드

			// total 구하기
			$sql = "SELECT COUNT(*) as cnt FROM jmmk_board_create";

			$stmt = db()->prepare($sql);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('총 레코드 수 조회 실패');
			}

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$total = $row['cnt'];

			// list 구하기
			$sql = "SELECT * FROM jmmk_board_create ORDER BY regDt DESC LIMIT :limit OFFSET :offset";

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

	// boardId에 따라 게시글 가져옴
	public function getList($boardId, $page = 1, $limit = 10){
		try{
			$url = siteUrl("board/list?id={$boardId}"); // boardId에 따라 url 만듦
			$page = $page?$page:1;
			$limit = $limit?$limit:10;
			$offset = ($page - 1) * $limit;
			
			// total 구하기

			$sql = "SELECT COUNT(*) as cnt FROM jmmk_board WHERE boardId = :boardId";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":boardId", $boardId);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('게시글 수 조회 실패');
			}

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$total = $row['cnt'];


			// list 구하기

			$sql = "SELECT * FROM jmmk_board WHERE boardId = :boardId ORDER BY regDt DESC LIMIT :limit OFFSET :offset";
			// WHERE 뒤에 ORDER BY랑 LIMIT 등 써야 오류 안 남

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
			$stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
			$stmt->bindValue(":boardId", $boardId);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('게시글 리스트 조회 실패');
			}

			$list = $stmt->fetchAll(PDO::FETCH_ASSOC);


			// boardNm 구하기

			$sql = "SELECT * FROM jmmk_board_create WHERE boardId = :boardId";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":boardId", $boardId);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('게시판명 조회 실패');
			}

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$boardNm = $row['boardNm'];


			$paginator = App::load(\Component\Core\Pagination::class, $page, $limit, $total, $url);

			$pagination = $paginator->getHTML();

			$data = [
				'boardId' => $boardId,
				'boardNm' => $boardNm, // 쓸 일 있어서 반환
				'list' => $list,
				'pagination' => $pagination,
			];

			return $data;

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	public function getBoardNm($boardId){
		try{
			$sql = "SELECT * FROM jmmk_board_create WHERE boardId = :boardId";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":boardId", $boardId);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('boardId로 레코드 조회 실패');
			}

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			return $row['boardNm'];

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	public function write(){

		$memNm = getSession('member_memNm');
		$boardId = $this->params['boardId'];
		$subject = $this->params['subject'];
		$contents = $this->params['contents'];
		$isLocked = $this->params['secure'];
		$fileGroup = $this->params['fileGroup'];

		// 게시글 작성 처리
		$sql = "INSERT INTO jmmk_board (boardId, memNm, subject, contents, isLocked, fileGroup) VALUES (:boardId, :memNm, :subject, :contents, :isLocked, :fileGroup)";

		$stmt = db()->prepare($sql);

		$bindData = ['boardId', 'memNm', 'subject', 'contents', 'isLocked', 'fileGroup'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('게시글 작성 DB 처리 실패');
		}

		// 파일 업로드 처리
		$file = App::load(\Component\Core\File::class);
		
		$result = $file->upload($fileGroup);

		if($result === false){
			throw new AlertException('파일 업로드 실패');
		}

		// isFileExists 처리
		$sql = "SELECT COUNT(*) as cnt FROM jmmk_file WHERE fileGroup = :fileGroup";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":fileGroup", $fileGroup);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('파일 그룹 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if($row['cnt'] > 0){
			$isFileExists = 1;
			$sql = "UPDATE jmmk_board SET isFileExists = :isFileExists WHERE fileGroup = :fileGroup";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":isFileExists", $isFileExists, PDO::PARAM_INT);
			$stmt->bindValue(":fileGroup", $fileGroup);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('isFileExists 업데이트 실패');
			}
		}

		// isImageExists 처리
		$isImage = 1;
		$sql = "SELECT COUNT(*) as cnt FROM jmmk_file WHERE fileGroup = :fileGroup AND isImage = :isImage";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":fileGroup", $fileGroup);
		$stmt->bindValue(":isImage", $isImage, PDO::PARAM_INT);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('파일 그룹 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if($row){
			$isImageExists = 1;
			$sql = "UPDATE jmmk_board SET isImageExists = :isImageExists WHERE fileGroup = :fileGroup";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":isImageExists", $isImageExists, PDO::PARAM_INT);
			$stmt->bindValue(":fileGroup", $fileGroup);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('isImageExists 업데이트 실패');
			}
		}

		return $result;
	}

	public function modify(){

		$boardId = $this->params['boardId'];
		$subject = $this->params['subject'];
		$contents = $this->params['contents'];
		$isLocked = $this->params['secure'];
		$postNo = $this->params['postNo'];

		// 잘못된 접근 처리 (postNo 바꿔서 수정하는 것 차단)
		$session_postNo = getSession('board_postNo');

		if($postNo !== $session_postNo){
			throw new AlertException('잘못된 접근입니다');
		}

		// 게시글 수정 처리
		$sql = "UPDATE jmmk_board SET subject = :subject, contents = :contents, isLocked = :isLocked WHERE postNo = :postNo";

		$stmt = db()->prepare($sql);

		$bindData = ['subject', 'contents', 'isLocked', 'postNo'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('게시글 수정 DB 처리 실패');
		}

		// 첨부파일 삭제 버튼이 활성화됐을 시 기존 파일 지우기
		if(isset($this->params['delete_file']) && $this->params['delete_file'] == 'on'){

			$file = App::load(\Component\Core\File::class);

			// fileGroup 조회
			$fileGroup = $file->getFileGroup($postNo);

			// 기존 파일 지우기
			$result = $file->deleteFiles($fileGroup);

			if($result === false){
				throw new AlertException('업로드된 파일 삭제 실패');
			}

			// isFileExists 처리
			$isFileExists = 0;
			$sql = "UPDATE jmmk_board SET isFileExists = :isFileExists WHERE fileGroup = :fileGroup";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":isFileExists", $isFileExists, PDO::PARAM_INT);
			$stmt->bindValue(":fileGroup", $fileGroup);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('isFileExists 업데이트 실패');
			}
		}

		// 새로 올라온 파일 있는지 확인
		$files = request()->files();
		$isUploadFileExists = false;
		foreach($files as $file){ 
			if($file['error'] == 0){
				$isUploadFileExists = true;
				break;
			}
		}

		// 새로 올라온 파일 있으면 기존 파일 지우고 업로드하기
		if($isUploadFileExists){
			$file = App::load(\Component\Core\File::class);

			// fileGroup 조회
			$fileGroup = $file->getFileGroup($postNo);

			// 기존 파일 지우기
			$result = $file->deleteFiles($fileGroup);

			if($result === false){
				throw new AlertException('업로드된 파일 삭제 실패');
			}

			// 파일 업로드
			
			$result = $file->upload($fileGroup);

			if($result === false){
				throw new AlertException('파일 업로드 실패');
			}

			// isFileExists 처리
			$isFileExists = 1;
			$sql = "UPDATE jmmk_board SET isFileExists = :isFileExists WHERE fileGroup = :fileGroup";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":isFileExists", $isFileExists, PDO::PARAM_INT);
			$stmt->bindValue(":fileGroup", $fileGroup);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('isFileExists 업데이트 실패');
			}
		}

		return $result;
	}

	public function getPost($postNo){
		$sql = "SELECT * FROM jmmk_board WHERE postNo = :postNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":postNo", $postNo);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('게시글 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row;
	}

	public function getPrevPost($boardId, $postNo){ // 이전글이라 함은 더 나중에 작성된 글을 말함
		try{
			$sql = "SELECT * FROM jmmk_board WHERE boardId = :boardId AND postNo > :postNo ORDER BY postNo ASC LIMIT 1";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":boardId", $boardId);
			$stmt->bindValue(":postNo", $postNo);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('prevPost 조회 실패');
			}

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			if($row){ // $row가 존재하면 (이전글이 존재하면)
				return [
					'postNo' => $row['postNo'],
					'subject' => $row['subject'],
				]; // 이전글 번호 반환
			}else{
				return false;
			}

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	public function getNextPost($boardId, $postNo){ // 다음글 번호 구하기
		try{
			$sql = "SELECT * FROM jmmk_board WHERE boardId = :boardId AND postNo < :postNo ORDER BY postNo DESC LIMIT 1";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":boardId", $boardId);
			$stmt->bindValue(":postNo", $postNo);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('nextPost 조회 실패');
			}

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			if($row){
				return [
					'postNo' => $row['postNo'],
					'subject' => $row['subject'],
				];
			}else{
				return false;
			}

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	public function updateViews($boardId, $postNo){
		$sql = "UPDATE jmmk_board SET views = views+1 WHERE boardId = :boardId AND postNo = :postNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":boardId", $boardId);
		$stmt->bindValue(":postNo", $postNo);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('조회수 업데이트 실패');
		}

		return $result;
	}

	public function deletePost($postNo){
		$sql = "DELETE FROM jmmk_board WHERE postNo = :postNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":postNo", $postNo);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('게시글 삭제 실패');
		}

		return $result;
	}
}