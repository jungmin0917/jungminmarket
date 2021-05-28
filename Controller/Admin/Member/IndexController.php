<?php

namespace Controller\Admin\Member;

use App;

class IndexController extends \Controller\Admin\AdminController{
	public function __construct(){
		go("admin/member/list");
	}
}