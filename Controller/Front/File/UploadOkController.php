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

			$fileClass = App::load(\Component\Core\File::class);

			extract($files);

			// 해당 파일그룹 당 최대 이미지 5개까지만 넣을 수 있게 한다

			$fileData = $fileClass->getImageList($fileGroup);

			if(count($fileData) >= 5){
				throw new AlertException('이미지는 최대 5개까지 업로드가 가능합니다');
			}

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

			// 이미지 업로드 후 업로드된 fileNo 반환받는다.
			$fileNo = $fileClass->uploadImage($fileGroup);

			if(!$fileNo){
				throw new AlertException('이미지 업로드 실패');
			}

			// 업로드된 파일 정보 가져오기
			$data = $fileClass->getFileInfo($fileNo);

			// 배열 형태인 파일 정보를 json 형태로 만든다. 
			$data = json_encode($data);

			// 파일 업로드 후 Callback 함수를 호출하여 본문에 삽입한다
			echo "<script>
					parent.parent.fileUploadCallback($data);
				</script>";

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}