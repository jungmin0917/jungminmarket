<?php

namespace Component\Core;

use App;
use PDO;
use Component\Exception\AlertException;

/* 파일 관련 Component */

class File{
	private $uploadPath = __DIR__ . "/../../assets/Upload/";

	// 일반 첨부파일 업로드 함수
	public function upload($fileGroup){
		try{
			$fileData = request()->files();

			foreach($fileData as $file){
				if($file['error']){ // 에러가 있는 경우
					continue; // 반복문 끝으로 감
				}

				// DB 처리
				$fileName = date("YmdHis")."_".$file['name'];
				$fileType = $file['type'];

				$sql = "INSERT INTO jmmk_file (fileGroup, fileName, fileType) VALUES (:fileGroup, :fileName, :fileType)";

				$stmt = db()->prepare($sql);

				$bindData = ['fileGroup', 'fileName', 'fileType'];

				foreach($bindData as $v){
					$stmt->bindValue(":{$v}", $$v);
				}

				$result = $stmt->execute();

				if($result === false){
					throw new AlertException('파일 업로드 실패');
				}

				// 파일 위치 옮기기 (실질 업로드)
				$uploadPath = $this->uploadPath;

				// 폴더 없으면 만들도록 하기
				if(!file_exists($uploadPath)){
					mkdir($uploadPath);
				}

				$result = move_uploaded_file($file['tmp_name'], $uploadPath.$fileName);

				if($result === false){
					throw new AlertException('파일 옮기기 실패');
				}
			}

			return $result;
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	// 이미지 업로드 함수
	public function uploadImage($fileGroup){
		try{
			$files = request()->files();

			extract($files);

			// DB 처리
			$isImage = 1;
			$fileName = date("YmdHis")."_".$file['name'];
			$fileType = $file['type'];

			$sql = "INSERT INTO jmmk_file (fileGroup, fileName, fileType, isImage) VALUES (:fileGroup, :fileName, :fileType, :isImage)";

			$stmt = db()->prepare($sql);

			$bindData = ['fileGroup', 'fileName', 'fileType', 'isImage'];

			foreach($bindData as $v){
				$stmt->bindValue(":{$v}", $$v);
			}

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('파일 업로드 실패');
			}

			// 파일 위치 옮기기
			$uploadPath = __DIR__ . "/../../assets/Upload/Image/";

			// 폴더 없으면 만들기
			if(!file_exists($uploadPath)){
				mkdir($uploadPath);
			}

			$result = move_uploaded_file($file['tmp_name'], $uploadPath.$fileName);

			if($result === false){
				throw new AlertException('파일 옮기기 실패');
			}

			// 업로드된 파일 정보 조회

			$fileNo = db()->lastInsertId();

			return $fileNo;
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}


	// 상품 이미지 업로드 함수
	public function uploadGoodsImage($fileGroup){
		try{
			$files = request()->files();

			extract($files);

			// DB 처리
			$isImage = 1;
			$isGoodsImage = 1;
			$fileName = date("YmdHis")."_".$file['name'];
			$fileType = $file['type'];

			$sql = "INSERT INTO jmmk_file (fileGroup, fileName, fileType, isImage, isGoodsImage) VALUES (:fileGroup, :fileName, :fileType, :isImage, :isGoodsImage)";

			$stmt = db()->prepare($sql);

			$bindData = ['fileGroup', 'fileName', 'fileType', 'isImage', 'isGoodsImage'];

			foreach($bindData as $v){
				$stmt->bindValue(":{$v}", $$v);
			}

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('파일 업로드 실패');
			}

			// 파일 위치 옮기기
			$uploadPath = __DIR__ . "/../../assets/Upload/Image/";

			// 폴더 없으면 만들기
			if(!file_exists($uploadPath)){
				mkdir($uploadPath);
			}

			$result = move_uploaded_file($file['tmp_name'], $uploadPath.$fileName);

			if($result === false){
				throw new AlertException('파일 옮기기 실패');
			}

			// 업로드된 파일 정보 조회

			$fileNo = db()->lastInsertId();

			return $fileNo;
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	// 파일 그룹으로 파일 리스트 조회 (이미지 첨부 파일 제외)
	public function getFileList($fileGroup){
		try{
			$isImage = 0;

			$sql = "SELECT * FROM jmmk_file WHERE fileGroup = :fileGroup AND isImage = :isImage";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":fileGroup", $fileGroup);
			$stmt->bindValue(":isImage", $isImage, PDO::PARAM_INT);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('파일 그룹 조회 실패');
			}

			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $rows;

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	// 파일 그룹으로 이미지 리스트 조회 (단순 첨부 파일 제외)
	public function getImageList($fileGroup){
		try{
			$isImage = 1;

			$sql = "SELECT * FROM jmmk_file WHERE fileGroup = :fileGroup AND isImage = :isImage";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":fileGroup", $fileGroup);
			$stmt->bindValue(":isImage", $isImage, PDO::PARAM_INT);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('파일 그룹 조회 실패');
			}

			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $rows;

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	// 파일 그룹으로 goodsImage 제외한 이미지 리스트 조회
	public function getImageListExceptGoodsImage($fileGroup){
		try{
			$isImage = 1;
			$isGoodsImage = 0;

			$sql = "SELECT * FROM jmmk_file WHERE fileGroup = :fileGroup AND isImage = :isImage AND isGoodsImage = :isGoodsImage";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":fileGroup", $fileGroup);
			$stmt->bindValue(":isImage", $isImage, PDO::PARAM_INT);
			$stmt->bindValue(":isGoodsImage", $isGoodsImage, PDO::PARAM_INT);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('파일 그룹 조회 실패');
			}

			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $rows;

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	// 파일 번호로 파일 정보 조회
	public function getFileInfo($fileNo){
		try{
			$sql = "SELECT * FROM jmmk_file WHERE fileNo = :fileNo";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":fileNo", $fileNo);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('파일 정보 조회 실패');
			}

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			if($data){
				if($data['isImage'] == 1){ // 업로드 경로 추가
					$data['url'] = siteUrl("assets/Upload/Image/{$data['fileName']}");
				}else{
					$data['url'] = siteUrl("assets/Upload/{$data['fileName']}");
				}
			}

			return $data;

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	public function getGoodsImageFileInfo($fileGroup){
		try{
			$isGoodsImage = 1;
			$sql = "SELECT * FROM jmmk_file WHERE fileGroup = :fileGroup AND isGoodsImage = :isGoodsImage";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":isGoodsImage", $isGoodsImage, PDO::PARAM_INT);
			$stmt->bindValue(":fileGroup", $fileGroup);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('파일 정보 조회 실패');
			}

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			return $row;

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	// 게시글 번호로 파일 그룹 조회
	public function getFileGroup($postNo){
		try{
			$sql = "SELECT * FROM jmmk_board WHERE postNo = :postNo";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":postNo", $postNo);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('fileGroup 조회 실패');
			}

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			return $row['fileGroup'];

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	// 파일 그룹으로 해당 파일들 지우기 (전부)
	public function deleteFiles($fileGroup){
		try{
			// 파일 지우기
			$sql = "SELECT * FROM jmmk_file WHERE fileGroup = :fileGroup";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":fileGroup", $fileGroup);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('지울 파일 조회 실패');
			}

			$uploadPath = $this->uploadPath; // 업로드 폴더 위치

			$fileList = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach($fileList as $file){
				$path = $uploadPath.$file['fileName'];
				if(file_exists($path)){
					unlink($path);
				}
			}

			// 파일 DB 지우기
			$sql = "DELETE FROM jmmk_file WHERE fileGroup = :fileGroup";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":fileGroup", $fileGroup);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('파일 DB 지우기 실패');
			}

			return $result;

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	// 첨부 파일만 지우기
	public function deleteFilesExceptImage($fileGroup){
		try{
			$isImage = 0;
			$sql = "SELECT * FROM jmmk_file WHERE fileGroup = :fileGroup AND isImage = :isImage";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":fileGroup", $fileGroup);
			$stmt->bindValue(":isImage", $isImage, PDO::PARAM_INT);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('지울 파일 조회 실패');
			}

			$uploadPath = $this->uploadPath; // 업로드 폴더 위치

			$fileList = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach($fileList as $file){
				$path = $uploadPath.$file['fileName'];
				if(file_exists($path)){
					unlink($path);
				}
			}

			// 파일 DB 지우기
			$sql = "DELETE FROM jmmk_file WHERE fileGroup = :fileGroup AND isImage = :isImage";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":fileGroup", $fileGroup);
			$stmt->bindValue(":isImage", $isImage, PDO::PARAM_INT);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('파일 DB 지우기 실패');
			}

			return $result;

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}


	// 파일 번호로 파일 지우기
	public function deleteFileByNo($fileNo){
		try{
			$sql = "SELECT * FROM jmmk_file WHERE fileNo = :fileNo";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":fileNo", $fileNo);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('파일 조회 실패');
			}

			$file = $stmt->fetch(PDO::FETCH_ASSOC);

			$uploadPath = $this->uploadPath;

			if($file['isImage'] == 1){ // 해당 파일이 이미지인 경우
				$path = $uploadPath."Image/".$file['fileName'];
			}else{ // 해당 파일이 단순 첨부 파일인 경우
				$path = $uploadPath.$file['fileName'];
			}

			// 실제 파일 삭제
			if(file_exists($path)){
				unlink($path);
			}

			// DB 처리

			$sql = "DELETE FROM jmmk_file WHERE fileNo = :fileNo";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":fileNo", $fileNo);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('파일 삭제 DB 처리 실패');
			}

			return $result;

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	public function download($fileName){

		$uploadPath = $this->uploadPath;

		// 해당 파일명이 이미지인지 확인

		$file = App::load(\Component\Core\File::class);

		$sql = "SELECT * FROM jmmk_file WHERE fileName = :fileName";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":fileName", $fileName);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('파일명으로 파일 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if($row['isImage'] == 1){
			$filePath = $uploadPath."Image/".$fileName;
		}else{
			$filePath = $uploadPath.$fileName;
		}

		$fileSize = filesize($filePath);

		header("Pragma: no-cache"); // 캐싱 방지
		header("Expires: 0"); // 캐싱 방지
		header("Content-Type: application/octet-stream");
		header("Content-Disposition:attachment; filename=$fileName");
		header("Content-Transfer-Encoding:binary");
		header("Content-Length:$fileSize");

		ob_clean();
		flush();
		readfile($filePath);
	}

	// 임시 파일 전부 지우기
	public function deleteTemporaryFiles(){
		// 조건은 jmmk_file의 isNotTemporary 값이 0일 경우

		$isNotTemporary = 0;
		$sql = "SELECT * FROM jmmk_file WHERE isNotTemporary = :isNotTemporary";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":isNotTemporary", $isNotTemporary, PDO::PARAM_INT);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('isNotTemporary로 레코드 조회 실패');
		}

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// 파일 지우기
		foreach($rows as $v){
			self::deleteFileByNo($v['fileNo']);
		}
	}

	public function thisIsNotTemporary($fileGroup){
		try{
			$isNotTemporary = 1;
			$sql = "UPDATE jmmk_file SET isNotTemporary = :isNotTemporary WHERE fileGroup = :fileGroup";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":fileGroup", $fileGroup);
			$stmt->bindValue(":isNotTemporary", $isNotTemporary);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('임시파일 여부 변경 DB 처리 실패');
			}

			return $result;

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}