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
}