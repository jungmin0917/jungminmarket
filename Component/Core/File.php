<?php

namespace Component\Core;

use App;
use PDO;
use Component\Exception\AlertException;

/* 파일 관련 Component */

class File{
	private $uploadPath = __DIR__ . "/../../assets/Upload/";

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

				if(file_exists($uploadPath)){
					$result = move_uploaded_file($file['tmp_name'], $uploadPath.$fileName);

					if($result === false){
						throw new AlertException('파일 옮기기 실패');
					}
				}
			}

			return $result;
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	// 파일 그룹으로 파일 리스트 조회
	public function getFileList($fileGroup){
		try{
			$sql = "SELECT * FROM jmmk_file WHERE fileGroup = :fileGroup";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":fileGroup", $fileGroup);

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

	// 파일 그룹으로 해당 파일들 지우기
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

			return;

		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}

	public function download($fileName){

		$uploadPath = $this->uploadPath;
		
		$filePath = $uploadPath.$fileName;
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
}