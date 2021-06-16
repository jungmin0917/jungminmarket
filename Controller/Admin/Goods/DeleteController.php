<?php

namespace Controller\Admin\Goods;

use App;
use Component\Exception\AlertException;

class DeleteController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			$goods = App::load(\Component\Goods\Goods::class);

			$file = App::load(\Component\Core\File::class);

			$goodsNo = request()->get('goodsNo');

			// 파일 삭제 처리부터 하기

			$goodsData = $goods->getGoods($goodsNo);

			$fileGroup = $goodsData['fileGroup'];

			// 해당 파일 그룹 모든 파일 삭제

			$result = $file->deleteFiles($fileGroup);

			if($result === false){
				throw new AlertException('상품 관련 파일 삭제 실패');
			}

			$result = $goods->delete($goodsNo);

			if($result === false){
				throw new AlertException('상품 삭제 실패');
			}

			alertReplace('상품 삭제에 성공했습니다. 상품 목록으로 돌아갑니다', 'admin/goods/list');

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}