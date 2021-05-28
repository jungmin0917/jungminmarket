<?php

namespace Controller\Admin\Order;

use App;

class IndexController extends \Controller\Admin\AdminController{
	public function __construct(){
		go("admin/order/list");
	}
}