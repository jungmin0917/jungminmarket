<?php

namespace Controller\Admin\Goods;

use App;
use Component\Exception\AlertException;

class IndbController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->layoutBlank = true;
	}
	
	public function index(){
		try{
			$formData = request()->all();

			$goods = App::load(\Component\Goods\Goods::class);

			switch($formData['mode']){
				case 'category_create':

					$result = $goods->data($formData)->validator('category_create')->createCategory();

					if($result === false){
						throw new AlertException('상품 분류 등록 실패');
					}

					alertReload("상품 분류 등록에 성공했습니다", "parent");

					break;

				default:
					break;
			}

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}