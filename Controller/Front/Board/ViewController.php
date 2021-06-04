<?php

namespace Controller\Front\Board;

use App;
use Component\Exception\AlertException;

class ViewController extends \Controller\Front\FrontController{

	public function index(){
		try{
			$postNo = request()->get('post');

			$boardId = request()->get('id');

			$board = App::load(\Component\Board\Board::class);

			$board->updateViews($boardId, $postNo);

			$boardNm = $board->getBoardNm($boardId);

			$data = $board->getPost($postNo);

			$data = array_merge($data, ['boardNm' => $boardNm]);
			
			$skin = $board->getSkin($boardId);

			App::render("Front/Board/Skins/{$skin}/view", $data);
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}