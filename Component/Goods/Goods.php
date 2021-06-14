<?php

namespace Component\Goods;

use App;
use PDO;
use Component\Exception\AlertException;

class Goods{
	private $params = [];

	public function data($params = []){
		$this->params = $params;
		return $this;
	}

	public function validator($mode){
		switch($mode){
			case 'category_create':
				if(!$this->params['categoryCode']){
					throw new AlertException('분류 코드를 입력해주세요');
				}
				if(!$this->params['categoryNm']){
					throw new AlertException('분류명을 입력해주세요');
				}

				self::categoryCodeValidate();

				break;

			default:
				break;
		}
		return $this;
	}

	public function categoryCodeValidate(){
		// 상품 분류코드 중복 검사
		$sql = "SELECT * FROM jmmk_goods_category WHERE categoryCode = :categoryCode";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":categoryCode", $this->params['categoryCode']);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('상품 분류코드로 레코드 검색 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if($row){ // 겹치는 분류코드가 있을 경우
			throw new AlertException('이미 존재하는 분류코드입니다');
		}
	}

	public function createCategory(){
		$categoryCode = $this->params['categoryCode'];
		$categoryNm = $this->params['categoryNm'];

		$sql = "INSERT INTO jmmk_goods_category (categoryCode, categoryNm) VALUES (:categoryCode, :categoryNm)";

		$stmt = db()->prepare($sql);

		$bindData = ['categoryCode', 'categoryNm'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('상품 분류 등록 DB 처리 실패');
		}

		return $result;
	}

	public function getCategoryList(){
		$sql = "SELECT * FROM jmmk_goods_category";

		$stmt = db()->prepare($sql);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('상품 분류 조회 실패');
		}

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}
}