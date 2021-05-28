<?php

namespace Controller\Admin\Board;

use App;

class IndexController extends \Controller\Admin\AdminController{
	public function __construct(){
		go("admin/board/list");
	}
}