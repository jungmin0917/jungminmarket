<?php

namespace Component\Comment;

use App;
use PDO;
use Component\Exception\AlertException;

class Comment{

	private $params = [];

	public function data($params = []){
		$this->params = $params;
		return $this;
	}

	public function validator($mode){
		switch($mode){
			case 'write':
				if(!$this->params['comment']){
					throw new AlertException('댓글 내용을 입력해주세요');
				}
				break;

			case 'modify':
				if(!$this->params['comment']){
					throw new AlertException('댓글 내용을 입력해주세요');
				}
				break;

			default:
				break;
		}
		return $this;
	}

	public function write(){
		$postNo = $this->params['postNo'];
		$memNo = getSession('member_memNo');
		$memNm = getSession('member_memNm');
		$comment = $this->params['comment'];

		$sql = "INSERT INTO jmmk_comment (postNo, memNo, memNm, comment) VALUES (:postNo, :memNo, :memNm, :comment)";

		$stmt = db()->prepare($sql);

		$bindData = ['postNo', 'memNo', 'memNm', 'comment'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('댓글 DB 처리 실패');
		}

		return $result;
	}

	public function getList($postNo){
		$sql = "SELECT * FROM jmmk_comment WHERE postNo = :postNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":postNo", $postNo);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('댓글 리스트 조회 실패');
		}

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}

	public function delete(){
		$commentNo = $this->params['commentNo'];

		$sql = "DELETE FROM jmmk_comment WHERE commentNo = :commentNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":commentNo", $commentNo);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('댓글 삭제 처리 실패');
		}

		return $result;
	}

	public function getComment($commentNo){
		$sql = "SELECT * FROM jmmk_comment WHERE commentNo = :commentNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":commentNo", $commentNo);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('댓글 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row;
	}

	public function modify($commentNo){
		$comment = $this->params['comment'];
		$isModified = 1;

		$sql = "UPDATE jmmk_comment SET comment = :comment, isModified = :isModified, modDt = now() WHERE commentNo = :commentNo";

		$stmt = db()->prepare($sql);

		$bindData = ['comment', 'commentNo', 'isModified'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('댓글 수정 실패');
		}

		return $result;
	}
}