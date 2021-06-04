<?php

namespace Controller\Front\Board;

use App;
use Component\Exception\AlertException;

class ModifyController extends \Controller\Front\FrontController{
	public function index(){
		try{
			$boardId = request()->get('id');
			$postNo = request()->get('post');

			// 임시 세션 처리 (다른 사람이 쿼리스트링 값 바꿔서 할 수 있으므로)
			setSession('board_postNo', $postNo);

			$board = App::load(\Component\Board\Board::class);

			$data = $board->getPost('post');

			$boardNm = $board->getBoardNm($boardId);
			$data = $board->getPost($postNo);
			$data = array_merge($data, ['boardNm' => $boardNm]);

			$skin = $board->getSkin($boardId);

			App::render("Front/Board/Skins/{$skin}/write", $data);
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}