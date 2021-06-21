<?php

namespace Controller\Front\File;

use App;
use Component\Exception\AlertException;

class UploadOkController extends \Controller\Front\FrontController{

	public function __construct(){
		$this->layoutBlank = true;
	}

	// 이미지 업로드 관련
	public function index(){
		try{
			$fileGroup = request()->get('fileGroup');

			$files = request()->files(); // files 객체 읽음

			$fileClass = App::load(\Component\Core\File::class);

			$formData = request()->post();

			extract($files);

			// 상품등록의 이미지 업로드(1개만)일 경우 -> 기존의 이미지 전부 삭제 후 업로드

			if(isset($formData['mode']) && $formData['mode'] == 'goodsImageSet'){
				$fileClass->deleteFiles($fileGroup);
			}

			// 배너 이미지도 마찬가지 (단, 배너 이미지는 fileGroup 에서 번호로 구분하므로 이렇게 해도 됨)
			if(isset($formData['mode']) && $formData['mode'] == 'bannerImageSet'){
				$fileClass->deleteFiles($fileGroup);
			}

			// 해당 파일그룹 당 최대 이미지 5개까지만 넣을 수 있게 한다

			$fileData = $fileClass->getImageList($fileGroup);

			if(count($fileData) >= 5){
				throw new AlertException('이미지는 최대 5개까지 업로드가 가능합니다');
			}

			// 파일 없을 경우
			if(!$file['name']){
				throw new AlertException('파일을 선택해주세요');
			}

			// 이미지 파일만 업로드 가능하게
			if($file['type'] != 'image/jpeg' && $file['type'] != 'image/png'){ // 타입이 image/png도 image/jpeg도 아닐 때
				throw new AlertException('jpg, png 파일만 지원합니다');
			}

			if($file['error']){
				throw new AlertException('업로드 에러입니다');
			}

			// 이미지 업로드 후 업로드된 fileNo 반환받는다.
			if(isset($formData['mode']) && $formData['mode'] == 'goodsImageSet'){ // 상품 메인 이미지인 경우
				$fileNo = $fileClass->uploadGoodsImage($fileGroup);
			}else if(isset($formData['mode']) && $formData['mode'] == 'bannerImageSet'){
				$fileNo = $fileClass->uploadBannerImage($fileGroup);
			}else{
				$fileNo = $fileClass->uploadImage($fileGroup); // CKEDITOR 내 이미지인 경우
			}

			if(!$fileNo){
				throw new AlertException('이미지 업로드 실패');
			}

			// 업로드된 파일 정보 가져오기
			$data = $fileClass->getFileInfo($fileNo);

			// 배열 형태인 파일 정보를 json 형태로 만든다. 
			$data = json_encode($data);

			// 파일 업로드 후 Callback 함수를 호출하여 본문에 삽입한다

			if(isset($formData['mode']) && $formData['mode'] == 'goodsImageSet'){ // 상품 메인 이미지인 경우
				echo "<script>
						parent.parent.goodsImageUploadCallback($data);
					</script>";
			}else if(isset($formData['mode']) && $formData['mode'] == 'bannerImageSet'){ // 배너 이미지인 경우
				echo "<script>
						parent.parent.bannerImageUploadCallback($data);
					</script>";
			}else{ // CKEDITOR 내 이미지인 경우
				echo "<script>
						parent.parent.fileUploadCallback($data);
					</script>";
			}

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}