<?php

namespace Controller\Admin\Board;

use App;
use Component\Exception\AlertException;

class ListController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'board';
		$this->subMenuCode = 'board_list';
	}

	public function subMenu(){
		App::render("Admin/Menus/boardMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){
		try{
			$board = App::load(\Component\Board\Board::class);

			$page = request()->get('page');

			$page = $page?$page:1; // 쿼리스트링 값 없으면 1
			$limit = 5;

			$data = $board->getBoardList($page, $limit); // 본격 쿼리 등 처리는 getList 안에서 함

			$skins = $board->getSkins();

			$data = array_merge($data, ['skins' => $skins]); // list에서 option 값으로 skins 자동 추가하기 위함

			App::render("Admin/Board/list", $data);
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}