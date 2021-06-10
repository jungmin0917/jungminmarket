<?php

namespace Controller\Front\Comment;

use App;
use Component\Exception\AlertException;

class ModifyController extends \Controller\Front\FrontController{

	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			$postData = request()->post();

			$board = App::load(\Component\Board\Board::class);

			$skin = $board->getSkin($postData['boardId']);

			$comment = App::load(\Component\Comment\Comment::class);

			$commentData = $comment->getComment($postData['commentNo']);
			
			// boardId를 데이터에 추가
			$commentData['boardId'] = $postData['boardId'];

			switch($postData['mode']){
				case "formCreate":
					App::render("Front/Board/Skins/{$skin}/comment_modify", ['commentData' => $commentData]);
					break;

				case "modify":
					$formData = request()->all();

					$result = $comment->data($formData)->validator('modify')->modify($postData['commentNo']);

					if($result === false){
						throw new AlertException('댓글 수정 실패');
					}

					// 댓글 리스트 가져오기
					$postNo = $postData['postNo'];

					$commentList = $comment->getList($postNo);

					App::render("Front/Board/Skins/{$skin}/comment_list", ['commentList' => $commentList]);
					break;

				default:
					break;
			}


		}catch(AlertException $e){

			// 댓글 수정 실패해도 기존 댓글 로딩은 하도록 만들었음

			$postNo = $postData['postNo'];

			$commentList = $comment->getList($postNo);

			App::render("Front/Board/Skins/{$skin}/comment_list", ['commentList' => $commentList]);

			echo $e;
		}
	}
}