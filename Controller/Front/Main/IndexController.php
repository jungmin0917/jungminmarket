<?php

namespace Controller\Front\Main;

use App;
use Component\Exception\AlertException;

class IndexController extends \Controller\Front\FrontController{
	public function index(){
		try{
			$board = App::load(\Component\Board\Board::class);

			$goods = App::load(\Component\Goods\Goods::class);

			$file = App::load(\Component\Core\File::class);

			$notice_list = $board->getList('notice', 1, 5);
			$event_list = $board->getList('event', 1, 5);

			$bannerImageList = $file->getBannerImageFiles();

			$bestGoodsList = $goods->getBestGoods(1, 6);

			$newGoodsList = $goods->getNewGoods(1, 6);

			$data = [
				'notice_list' => $notice_list,
				'event_list' => $event_list,
				'bannerImageList' => $bannerImageList,
				'bestGoodsList' => $bestGoodsList['list'],
				'newGoodsList' => $newGoodsList['list'],
			];

			App::render("Front/Main/index", $data);

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}