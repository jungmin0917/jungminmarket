<?php

namespace Controller\Front\Comment;

use App;
use Component\Exception\AlertException;

class WriteController extends \Controller\Front\FrontController{

	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			// DB 처리
			$formData = request()->post();

			$board = App::load(\Component\Board\Board::class);

			$skin = $board->getSkin($formData['boardId']);

			$comment = App::load(\Component\Comment\Comment::class);

			$result = $comment->data($formData)->validator('write')->write();

			if($result === false){
				throw new AlertException('댓글 등록 실패');
			}

			// 댓글 리스트 가져오기
			$postNo = $formData['postNo'];

			$commentList = $comment->getList($postNo);

			// 댓글창 새로고침 하기 (새로 rendering)
			App::render("Front/Board/Skins/{$skin}/comment_list", ['commentList' => $commentList]);
			// render하면 HTML이 생성되는데 그것을 res로 반환하는 것임
			
		}catch(AlertException $e){

			// 댓글 입력 실패해도 기존 댓글 로딩은 하도록 만들었음

			$postNo = $formData['postNo'];

			$commentList = $comment->getList($postNo);

			App::render("Front/Board/Skins/{$skin}/comment_list", ['commentList' => $commentList]);

			echo $e;
		}
	}
}