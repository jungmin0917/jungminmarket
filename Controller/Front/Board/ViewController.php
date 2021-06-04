<?php

namespace Controller\Front\Board;

use App;
use Component\Exception\AlertException;

class ViewController extends \Controller\Front\FrontController{

	public function __construct(){
		$postNo = request()->get('post');

		$board = App::load(\Component\Board\Board::class);

		$data = $board->getPost($postNo);

		// 본인 확인
		if($data['isLocked'] == 'locked'){
			if($data['memNm'] !== getSession('member_memNm')){
				alertBack('해당 글은 비밀글입니다');
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

			App::render("Front/Board/Skins/{$skin}/view", $data);
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}