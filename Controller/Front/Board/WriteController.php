<?php

namespace Controller\Front\Board;

use App;

class WriteController extends \Controller\Front\FrontController{

	public function __construct(){
		$boardId = request()->get('id');

		if($boardId = 'notice' || $boardId = 'event'){	
			if(!isAdminLogin()){
				alertBack('관리자만 접근 가능합니다. 이전 페이지로 이동합니다');
			}
		}
	}

	public function index(){
		
	}
}