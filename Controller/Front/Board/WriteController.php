<?php

namespace Controller\Front\Board;

use App;

class WriteController extends \Controller\Front\FrontController{

	public function __construct(){
		$boardId = request()->get('id');

		if(!isLogin()){
			alertGo('로그인을 먼저 해주세요. 로그인 페이지로 이동합니다', "member/login");
		}

		if($boardId == 'notice' || $boardId == 'event'){	
			if(!isAdminLogin()){
				alertBack('관리자만 접근 가능합니다. 이전 페이지로 이동합니다');
			}
		}
	}

	public function index(){
		$boardId = request()->get('id');

		$board = App::load(\Component\Board\Board::class);

		$skin = $board->getSkin($boardId);

		$boardNm = $board->getBoardNm($boardId);

		App::render("Front/Board/Skins/{$skin}/write", ['boardId' => $boardId, 'boardNm' => $boardNm]);
	}
}