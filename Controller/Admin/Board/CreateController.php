<?php

namespace Controller\Admin\Board;

use App;

class CreateController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'board';
		$this->subMenuCode = 'board_create';
	}

	public function subMenu(){
		App::render("Admin/Menus/boardMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){
		$board = App::load(\Component\Board\Board::class);
		$skins = $board->getSkins();

		App::render("Admin/Board/create", ['skins' => $skins]);
	}
}