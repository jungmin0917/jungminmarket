<?php

namespace Controller\Admin\Order;

use App;

class ListController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'order';
		$this->subMenuCode = 'order_list';
	}

	public function subMenu(){
		App::render("Admin/Menus/orderMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){

	}
}