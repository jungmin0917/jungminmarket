<?php

namespace Controller\Admin\Goods;

use App;
use Component\Exception\AlertException;

class UpdateController extends \Controller\Admin\AdminController{

	public function __construct(){
		$this->topMenuCode = 'goods';
		$this->subMenuCode = 'goods_update';
	}

	public function subMenu(){
		App::render("Admin/Menus/goodsMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){
		try{
			$goods = App::load(\Component\Goods\Goods::class);

			$goodsNo = request()->get('goodsNo');

			$goodsData = $goods->getGoods($goodsNo);

			$categoryList = $goods->getCategoryList();

			// 상세 설명 이미지 가져오기
			$file = App::load(\Component\Core\File::class);

			$imageList = $file->getImageListExceptGoodsImage($goodsData['fileGroup']);

			App::render("Admin/Goods/register", ['categoryList' => $categoryList, 'goodsData' => $goodsData, 'imageList' => $imageList]);

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}