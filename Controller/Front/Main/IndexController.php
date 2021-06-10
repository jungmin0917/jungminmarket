<?php

namespace Controller\Front\Main;

use App;

class IndexController extends \Controller\Front\FrontController{
	public function index(){

		$board = App::load(\Component\Board\Board::class);

		$notice_list = $board->getList('notice', 1, 5);
		$event_list = $board->getList('event', 1, 5);

		$data = [
			'notice_list' => $notice_list,
			'event_list' => $event_list,
		];

		App::render("Front/Main/index", $data);
	}
}