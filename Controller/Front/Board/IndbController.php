<?php

namespace Controller\Front\Board;

use App;
use PDO;
use Component\Exception\AlertException;

class IndbController extends \Controller\Front\FrontController{

	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			$formData = request()->all();

			$board = App::load(\Component\Board\Board::class);

			$boardId = $formData['boardId'];

			switch($formData['mode']){
				case 'write':
					$result = $board->data($formData)->validator('write')->write();

					if($result === false){
						throw new AlertException('게시글 작성 실패');
					}

					alertGo("게시글 작성에 성공했습니다. 게시글 목록으로 이동합니다", "board/list?id={$boardId}", "parent");

					// 성공 시

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