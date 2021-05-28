<?php

namespace Controller\Admin\Member;

use App;

class ConfigController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'member';
		$this->subMenuCode = 'member_config';
	}

	public function subMenu(){
		App::render("Admin/Menus/memberMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){
		$member = App::load(\Component\Member\Member::class);

		$data = $member->getTerms();

		App::render("Admin/Member/config", $data);
	}
}