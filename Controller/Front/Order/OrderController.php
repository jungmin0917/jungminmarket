<?php

namespace Controller\Front\Order;

use App;
use Component\Exception\AlertException;

class OrderController extends \Controller\Front\FrontController{

	public function index(){
		try{
			$formData = request()->all();

			App::render("Front/Order/order");

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}