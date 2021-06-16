<?php

namespace Controller\Front\File;

use App;
use Component\Exception\AlertException;

class DeleteTemporaryController extends \Controller\Front\FrontController{

	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			$file = App::load(\Component\Core\File::class);

			$result = $file->deleteTemporaryFiles();

			if($result === false){
				throw new AlertException('임시파일 삭제 실패');
			}

			alertReload('임시파일이 전부 삭제되었습니다', 'parent');
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}