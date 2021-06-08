<?php

namespace Controller\Front\File;

use App;
use Component\Exception\AlertException;

class UploadOkController extends \Controller\Front\FrontController{

	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			$fileGroup = request()->get('fileGroup');
			$files = request()->files();

			extract($files);

			// 파일 없을 경우
			if(!$file['name']){
				throw new AlertException('파일을 선택해주세요');
			}

			if($file['type'] != 'image/jpeg' && $file['type'] != 'image/png'){ // 타입이 image/png도 image/jpeg도 아닐 때
				throw new AlertException('jpg, png 파일만 지원합니다');
			}

			if($file['error']){
				throw new AlertException('업로드 에러입니다');
			}

			$fileClass = App::load(\Component\Core\File::class);

			$fileNo = $fileClass->uploadImage($fileGroup);

			if(!$fileNo){
				throw new AlertException('이미지 업로드 실패');
			}

			$data = $fileClass->getFileInfo($fileNo);

			$data = json_encode($data);

			echo "<script>
					parent.parent.fileUploadCallback($data);
				</script>";

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}