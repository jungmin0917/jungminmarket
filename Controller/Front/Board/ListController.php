<?php

namespace Controller\Front\Board;

use App;

class ListController extends \Controller\Front\FrontController{
	public function index(){
		// 쿼리스트링값인 id를 받아서 그거에 따라 다른 데이터를 받아와서 넘길 것임.

		$boardId = request()->get('id');

		$board = App::load(\Component\Board\Board::class);

		$skin = $board->getSkin($boardId);

		$page = request()->get('page');

		$page = $page ?? 1;
		$limit = 5;

		$searchType = request()->get('searchType');
		$searchWord = request()->get('searchWord');

		if($searchWord){ // 검색어 있을 경우
			$data = $board->getList($boardId, $page, $limit, $searchType, $searchWord);

			$data['searchWord'] = $searchWord;
			$data['searchType'] = $searchType;
		}else{
			$data = $board->getList($boardId, $page, $limit);
		}

		App::render("Front/Board/Skins/{$skin}/list", $data); // input hidden값 Id에 따라 넣을 것임
	}
}