<?php

namespace Controller\Front\File;

use App;
use Component\Exception\AlertException;

class DeleteController extends \Controller\Front\FrontController{

	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			$fileNo = request()->post('fileNo');

			$file = App::load(\Component\Core\File::class);

			if($fileNo){
				$result = $file->deleteFileByNo($fileNo);
				if($result){
					echo 1; // 파일 삭제 성공 시
					exit;
				}
			}

			echo 0; // 파일 삭제 실패 시

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}