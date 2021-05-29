<?php

namespace Controller\Admin\Member;

use App;
use PDO;
use Component\Exception\AlertException;

class ListController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'member';
		$this->subMenuCode = 'member_list';
	}

	public function subMenu(){
		App::render("Admin/Menus/memberMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){
		$member = App::load(\Component\Member\Member::class);

		$page = request()->get('page');

		$page = $page?$page:1; // 쿼리스트링 값 없으면 1
		$limit = 5;

		$data = $member->getList($page, $limit); // 본격 쿼리 등 처리는 getList 안에서 함

		App::render("Admin/Member/list", $data);
	}
}