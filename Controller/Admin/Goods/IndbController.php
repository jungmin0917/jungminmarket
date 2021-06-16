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
				case 'register':

					$result = $goods->data($formData)->validator('register')->register();

					if($result === false){
						throw new AlertException('상품 등록 실패');
					}

					alertReplace('상품 등록에 성공했습니다. 상품 목록으로 이동합니다', 'admin/goods/list', 'parent');

					break;

				case 'update':

					$result = $goods->data($formData)->validator('update')->update();

					if($result === false){
						throw new AlertException('상품 수정 실패');
					}

					alertReplace('상품 수정에 성공했습니다. 상품 목록으로 이동합니다', 'admin/goods/list', 'parent');

					break;
				
				case 'category_create':

					$result = $goods->data($formData)->validator('category_create')->createCategory();

					if($result === false){
						throw new AlertException('상품 분류 등록 실패');
					}

					alertReload("상품 분류 등록에 성공했습니다", "parent");

					break;

				case 'category_modify':

					$result = $goods->data($formData)->modifyCategory();

					if($result === false){
						throw new AlertException('상품 분류 수정 실패');
					}

					alertReload("상품 분류 수정에 성공했습니다", "parent");

					break;

				case 'goods_list_update':

					$result = $goods->data($formData)->validator('goods_list_update')->goodsListUpdate();

					if($result === false){
						throw new AlertException('상품 목록 일괄 수정 실패');
					}

					alertReload("상품 목록 일괄 수정에 성공했습니다", "parent");

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