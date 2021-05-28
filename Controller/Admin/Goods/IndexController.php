<?php

namespace Controller\Admin\Goods;

use App;

class IndexController extends \Controller\Admin\AdminController{
	public function __construct(){
		go("admin/goods/list");
	}
}