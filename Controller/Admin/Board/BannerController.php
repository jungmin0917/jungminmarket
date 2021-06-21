<?php

namespace Controller\Admin\Board;

use App;
use Component\Exception\AlertException;

class BannerController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->topMenuCode = 'board';
		$this->subMenuCode = 'board_banner';
	}

	public function subMenu(){
		App::render("Admin/Menus/boardMenu", ['subMenuCode' => $this->subMenuCode]);
	}

	public function index(){
		try{
			$file = App::load(\Component\Core\File::class);

			$bannerImageList = $file->getBannerImageFiles();

			App::render("Admin/Board/banner", ['bannerImageList' => $bannerImageList]);
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}