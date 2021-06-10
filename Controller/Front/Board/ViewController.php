<?php

namespace Controller\Front\Board;

use App;
use Component\Exception\AlertException;

class ViewController extends \Controller\Front\FrontController{

	public function __construct(){
		$postNo = request()->get('post');

		$board = App::load(\Component\Board\Board::class);

		$data = $board->getPost($postNo);

		// 관리자가 아닌 경우 본인 확인 진행
		if(getSession('member_memLv') != 10){
			if($data['isLocked'] == 'locked'){
				if($data['memNm'] !== getSession('member_memNm')){
					alertBack('해당 글은 비밀글입니다');
				}
			}
		}
	}

	public function index(){
		try{
			$postNo = request()->get('post');
			$boardId = request()->get('id');

			$board = App::load(\Component\Board\Board::class);

			$boardNm = $board->getBoardNm($boardId);
			$data = $board->getPost($postNo);

			$board->updateViews($boardId, $postNo);

			$data = array_merge($data, ['boardNm' => $boardNm]);
			
			$skin = $board->getSkin($boardId);

			// 댓글 초기 로딩
			$comment = App::load(\Component\Comment\Comment::class);

			$commentList = $comment->getList($postNo);

			// 댓글 출력
			ob_start();
			App::render("Front/Board/Skins/{$skin}/comment_list", ['commentList' => $commentList]);
			$data['commentList'] = ob_get_clean(); // $data 배열 내에 commentList 속성 만들어서 거기에 집어넣음

			App::render("Front/Board/Skins/{$skin}/view", $data);

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}