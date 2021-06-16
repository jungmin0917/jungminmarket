<?php

namespace Controller\Admin\Etc;

use App;

class IndexController extends \Controller\Admin\AdminController{
	public function __construct(){
		go("admin/etc/temporary");
	}
}