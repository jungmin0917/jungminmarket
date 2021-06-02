<?php

namespace Controller\Admin\Board;

use App;
use Component\Exception\AlertException;

class IndbController extends \Controller\Admin\AdminController{
	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			$formData = request()->all();

			$board = App::load(\Component\Board\Board::class);

			switch($formData['mode']){
				case 'create':
					$result = $board->data($formData)->validator('create')->create();

					if($result === false){
						throw new AlertException('게시판 생성 실패');
					}

					alertReplace("게시판 생성에 성공했습니다. 게시판 목록으로 이동합니다", "admin/board/list", "parent");

					break;

				case 'updateNameSkin':
					$result = $board->data($formData)->validator('updateNameSkin')->updateNameSkin();

					if($result === false){
						throw new AlertException('게시판 일괄 변경 실패');
					}

					alertReload("게시판 일괄 변경에 성공했습니다.", "parent");

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