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
			case 'register':
				if(!$this->params['goodsNm']){
					throw new AlertException('상품명을 입력해주세요');
				}
				if(!$this->params['shortDesc']){
					throw new AlertException('상품 간단설명을 입력해주세요');
				}
				if(!$this->params['defaultPrice']){
					throw new AlertException('상품 원가를 입력해주세요');
				}
				if(!$this->params['salePrice']){
					throw new AlertException('상품 판매가를 입력해주세요');
				}

				self::goodsNmValidate();
				self::shortDescValidate();
				self::defaultPriceValidate();
				self::salePriceValidate();
				self::goodsImageValidate();

				break;

			case 'update':
				if(!$this->params['goodsNm']){
					throw new AlertException('상품명을 입력해주세요');
				}
				if(!$this->params['shortDesc']){
					throw new AlertException('상품 간단설명을 입력해주세요');
				}
				if(!$this->params['defaultPrice']){
					throw new AlertException('상품 원가를 입력해주세요');
				}
				if(!$this->params['salePrice']){
					throw new AlertException('상품 판매가를 입력해주세요');
				}

				self::goodsNmValidate();
				self::shortDescValidate();
				self::defaultPriceValidate();
				self::salePriceValidate();
				self::goodsImageValidate();

				break;

			case 'category_create':
				if(!$this->params['categoryCode']){
					throw new AlertException('분류 코드를 입력해주세요');
				}
				if(!$this->params['categoryNm']){
					throw new AlertException('분류명을 입력해주세요');
				}

				self::categoryCodeValidate();

				break;

			case 'goods_list_update':
				if(!isset($this->params['goodsNo'])){
					throw new AlertException('변경할 항목을 선택해주세요');
				}

				foreach($this->params['stock'] as $v){
					if(preg_match("/[^0-9]/", $v) || $v < 0){
						throw new AlertException('재고는 양의 숫자로 입력해주세요');
					}
				}

				break;

			default:
				break;
		}
		return $this;
	}

	public function register(){
		$categoryCode = $this->params['categoryCode'];
		$goodsNm = $this->params['goodsNm'];
		$shortDesc = $this->params['shortDesc'];
		$longDesc = $this->params['longDesc'];
		$defaultPrice = $this->params['defaultPrice'];
		$salePrice = $this->params['salePrice'];
		$stock = $this->params['stock'];
		$isSoldout = $this->params['isSoldout'];
		$isDisplay = $this->params['isDisplay'];
		$fileGroup = $this->params['fileGroup'];

		$sql = "INSERT INTO jmmk_goods (categoryCode, goodsNm, shortDesc, longDesc, defaultPrice, salePrice, stock, isSoldout, isDisplay, fileGroup) VALUES (:categoryCode, :goodsNm, :shortDesc, :longDesc, :defaultPrice, :salePrice, :stock, :isSoldout, :isDisplay, :fileGroup)";

		$stmt = db()->prepare($sql);

		$bindData = ['categoryCode', 'goodsNm', 'shortDesc', 'longDesc', 'defaultPrice', 'salePrice', 'stock', 'isSoldout', 'isDisplay', 'fileGroup'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('상품 등록 DB 처리 실패');
		}

		// 임시파일 여부 변경 처리
		$file = App::load(\Component\Core\File::class);

		$result = $file->thisIsNotTemporary($fileGroup);

		if($result === false){
			throw new AlertException('임시파일 여부 변경 실패');
		}

		return $result;
	}

	public function update(){
		$goodsNo = $this->params['goodsNo']; // 수정 시 필요
		$categoryCode = $this->params['categoryCode'];
		$goodsNm = $this->params['goodsNm'];
		$shortDesc = $this->params['shortDesc'];
		$longDesc = $this->params['longDesc'];
		$defaultPrice = $this->params['defaultPrice'];
		$salePrice = $this->params['salePrice'];
		$stock = $this->params['stock'];
		$isSoldout = $this->params['isSoldout'];
		$isDisplay = $this->params['isDisplay'];
		$fileGroup = $this->params['fileGroup'];

		$sql = "UPDATE jmmk_goods SET categoryCode = :categoryCode, goodsNm = :goodsNm, shortDesc = :shortDesc, longDesc = :longDesc, defaultPrice = :defaultPrice, salePrice = :salePrice, stock = :stock, isSoldout = :isSoldout, isDisplay = :isDisplay WHERE goodsNo = :goodsNo";

		$stmt = db()->prepare($sql);

		$bindData = ['categoryCode', 'goodsNm', 'shortDesc', 'longDesc', 'defaultPrice', 'salePrice', 'stock', 'isSoldout', 'isDisplay', 'goodsNo'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('상품 수정 DB 처리 실패');
		}
		
		// 임시파일 여부 변경 처리
		$file = App::load(\Component\Core\File::class);

		$result = $file->thisIsNotTemporary($fileGroup);

		if($result === false){
			throw new AlertException('임시파일 여부 변경 실패');
		}

		return $result;
	}

	public function delete($goodsNo){
		$sql = "DELETE FROM jmmk_goods WHERE goodsNo = :goodsNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":goodsNo", $goodsNo);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('상품 삭제 DB 처리 실패');
		}

		return $result;
	}

	public function goodsNmValidate(){
		$goodsNm = $this->params['goodsNm'];

		if(strlen($goodsNm) > 100){
			throw new AlertException('상품명이 너무 깁니다');
		}
	}

	public function shortDescValidate(){
		$shortDesc = $this->params['shortDesc'];

		if(strlen($shortDesc) > 255){
			throw new AlertException('상품 간단설명이 너무 깁니다');
		}
	}

	public function defaultPriceValidate(){
		$defaultPrice = $this->params['defaultPrice'];

		if($defaultPrice < 0 || preg_match("/[^0-9]/", $defaultPrice)){
			throw new AlertException('상품 원가는 양의 정수로 입력해주세요');
		}
	}

	public function salePriceValidate(){
		$salePrice = $this->params['salePrice'];

		if($salePrice < 0 || preg_match("/[^0-9]/", $salePrice)){
			throw new AlertException('상품 판매가는 양의 정수로 입력해주세요');
		}
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

	public function goodsImageValidate(){
		// 이미지는 반드시 하나 올리게 하기
		$file = App::load(\Component\Core\File::class);
		$data = $file->getGoodsImageFileInfo($this->params['fileGroup']);

		if(!$data){
			throw new AlertException('메인 이미지를 등록해주세요');
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

	public function getCategoryNm($categoryCode){
		$sql = "SELECT * FROM jmmk_goods_category WHERE categoryCode = :categoryCode";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":categoryCode", $categoryCode);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('카테고리명 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row['categoryNm'];
	}

	public function modifyCategory(){

		if(!isset($this->params['categoryNo']) || !$this->params['categoryNo']){
			throw new AlertException('변경할 상품 분류를 선택해주세요');
		}

		$categoryNo = $this->params['categoryNo'];
		$isDisplay = $this->params['isDisplay'];

		foreach($categoryNo as $k => $v){

			$sql = "UPDATE jmmk_goods_category SET isDisplay = :isDisplay WHERE categoryNo = :categoryNo";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":isDisplay", $isDisplay[$k]);
			$stmt->bindValue(":categoryNo", $k);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('상품 분류 수정 처리 실패');
			}
		}
		return $result;
	}

	// 상품 리스트 가져오기
	public function getGoodsList($page = 1, $limit = 10){
		$url = siteUrl("admin/goods/list");
		$page = $page?$page:1;
		$limit = $limit?$limit:10;
		$offset = ($page - 1) * $limit;


		// total 구하기

		$sql = "SELECT COUNT(*) as cnt FROM jmmk_goods";

		$stmt = db()->prepare($sql);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('상품 총 개수 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$total = $row['cnt'];


		// list 구하기

		$sql = "SELECT * FROM jmmk_goods ORDER BY regDt DESC LIMIT :limit OFFSET :offset";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
		$stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('상품 리스트 조회 실패');
		}

		$list = $stmt->fetchAll(PDO::FETCH_ASSOC);


		// 페이징하기

		$paginator = App::load(\Component\Core\Pagination::class, $page, $limit, $total, $url);

		$pagination = $paginator->getHTML();

		$data = [
			'list' => $list,
			'pagination' => $pagination,
		];

		return $data;
	}

	public function goodsListUpdate(){
		foreach($this->params['goodsNo'] as $k => $v){
			$sql = "UPDATE jmmk_goods SET stock = :stock, isSoldout = :isSoldout, isDisplay = :isDisplay WHERE goodsNo = :goodsNo";

			$stmt = db()->prepare($sql);

			$stmt->bindValue(":stock", $this->params['stock'][$k]);
			$stmt->bindValue(":isSoldout", $this->params['isSoldout'][$k]);
			$stmt->bindValue(":isDisplay", $this->params['isDisplay'][$k]);
			$stmt->bindValue(":goodsNo", $k);

			$result = $stmt->execute();

			if($result === false){
				throw new AlertException('상품 목록 일괄 변경 DB 처리 실패');
			}
		}

		return $result;
	}

	public function getGoods($goodsNo){
		$sql = "SELECT * FROM jmmk_goods WHERE goodsNo = :goodsNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":goodsNo", $goodsNo);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('상품 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row;
	}

	public function getGoodsCountByCategory($category){
		$sql = "SELECT COUNT(*) as cnt FROM jmmk_goods WHERE categoryCode = :categoryCode";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":categoryCode", $category);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('전체 상품 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row['cnt'];
	}

	public function getGoodsByCategory($category, $page = 1, $limit = 6, $sort = null){

		// $url을 정제해야 한다.
		$url = $_SERVER['REQUEST_URI'];

		if(preg_match("/$page/", $url)){

			$pattern = "/.+?(?=&page)/";

			preg_match($pattern, $url, $matches);

			$url = $matches[0];
		}else{
			// $url 그대로
		}

		// 정규표현식 쓰기
		$page = $page?$page:1;
		$limit = $limit?$limit:6;
		$offset = ($page - 1) * $limit;


		// total 구하기

		$isDisplay = 1;
		$sql = "SELECT COUNT(*) as cnt FROM jmmk_goods WHERE categoryCode = :categoryCode AND isDisplay = :isDisplay";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":categoryCode", $category);
		$stmt->bindValue(":isDisplay", $isDisplay, PDO::PARAM_INT);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('카테고리 걸어서 상품 총 개수 조회 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$total = $row['cnt'];



		// list 구하기

		$isDisplay = 1;
		if(!$sort || $sort == 'new'){
			$sql = "SELECT * FROM jmmk_goods WHERE categoryCode = :categoryCode AND isDisplay = :isDisplay ORDER BY regDt DESC LIMIT :limit OFFSET :offset";
		}else if($sort == 'low_cost'){
			$sql = "SELECT * FROM jmmk_goods WHERE categoryCode = :categoryCode AND isDisplay = :isDisplay ORDER BY salePrice ASC LIMIT :limit OFFSET :offset";
		}else if($sort == 'high_cost'){
			$sql = "SELECT * FROM jmmk_goods WHERE categoryCode = :categoryCode AND isDisplay = :isDisplay ORDER BY salePrice DESC LIMIT :limit OFFSET :offset";
		}else if($sort == 'sell_point'){
			$sql = "SELECT * FROM jmmk_goods WHERE categoryCode = :categoryCode AND isDisplay = :isDisplay ORDER BY salePoint DESC LIMIT :limit OFFSET :offset";
		}

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":categoryCode", $category);
		$stmt->bindValue(":isDisplay", $isDisplay, PDO::PARAM_INT);
		$stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
		$stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('카테고리로 상품 조회 실패');
		}	

		$list = $stmt->fetchAll(PDO::FETCH_ASSOC);


		// 페이징하기

		$paginator = App::load(\Component\Core\Pagination::class, $page, $limit, $total, $url);

		$pagination = $paginator->getHTML();

		$data = [
			'list' => $list,
			'pagination' => $pagination,
		];

		return $data;
	}


	public function addCart(){
		$memNo = $this->params['memNo'];
		$goodsNo = $this->params['goodsNo'];
		$goodsCount = $this->params['goodsCount'];
		$optionNo = $this->params['optionNo'] ?? ''; // 선택
		$isDirect = $this->params['isDirect'];

		$sql = "INSERT INTO jmmk_cart (memNo, goodsNo, goodsCount, optionNo, isDirect) VALUES (:memNo, :goodsNo, :goodsCount, :optionNo, :isDirect)";

		$stmt = db()->prepare($sql);

		$bindData = ['memNo', 'goodsNo', 'goodsCount', 'optionNo', 'isDirect'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('장바구니 추가 DB 처리 실패');
		}

		return $result;
	}

	public function getCart($cartNo){
		$sql = "SELECT * FROM jmmk_cart WHERE cartNo = :cartNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":cartNo", $cartNo);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('장바구니 조회 DB 처리 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row;
	}

	public function getisDirectCart($memNo){
		$isDirect = 1;
		$sql = "SELECT * FROM jmmk_cart WHERE isDirect = :isDirect AND memNo = :memNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":isDirect", $isDirect, PDO::PARAM_INT);
		$stmt->bindValue(":memNo", $memNo);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('바로구매 목록 삭제 DB 처리 실패');
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row['cartNo'];
	}

	public function getCartList($memNo){

		// isDirect가 0인 상품만 가져오기

		$isDirect = 0;
		$sql = "SELECT * FROM jmmk_cart WHERE memNo = :memNo AND isDirect = :isDirect";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":memNo", $memNo);
		$stmt->bindValue(":isDirect", $isDirect, PDO::PARAM_INT);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('장바구니 조회 DB 처리 실패');
		}

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}

	public function deleteBuyNowCart($memNo){
		$isDirect = 1;
		$sql = "DELETE FROM jmmk_cart WHERE isDirect = :isDirect AND memNo = :memNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":isDirect", $isDirect, PDO::PARAM_INT);
		$stmt->bindValue(":memNo", $memNo);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('바로구매 목록 삭제 DB 처리 실패');
		}

		return $result;
	}

	public function updateCart(){
		$cartNo = $this->params['cartNo'];
		$goodsCount = $this->params['goodsCount'];

		$sql = "UPDATE jmmk_cart SET goodsCount = :goodsCount WHERE cartNo = :cartNo";

		$stmt = db()->prepare($sql);

		$bindData = ['cartNo', 'goodsCount'];

		foreach($bindData as $v){
			$stmt->bindValue(":{$v}", $$v);
		}

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('장바구니 업데이트 DB 처리 실패');
		}

		return $result;
	}

	public function deleteCart($cartNo){
		$sql = "DELETE FROM jmmk_cart WHERE cartNo = :cartNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":cartNo", $cartNo);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('장바구니 상품 삭제 DB 처리 실패');
		}

		return $result;
	}

	public function deleteCartAll($memNo){
		$sql = "DELETE FROM jmmk_cart WHERE memNo = :memNo";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":memNo", $memNo);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('장바구니 비우기 DB 처리 실패');
		}

		return $result;
	}

	public function getNewGoods($page, $limit){
		$url = siteUrl("goods/list?category=new");
		$page = $page?$page:1;
		$limit = $limit?$limit:6;
		$offset = ($page - 1) * $limit;


		// total 구하기 (30개 고정이긴 한데 30개보다 적을 수 있으니 구함)

		$isDisplay = 1;
		$limit_total = 30;
		$sql = "SELECT * FROM jmmk_goods WHERE isDisplay = :isDisplay LIMIT :limit";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":isDisplay", $isDisplay, PDO::PARAM_INT);
		$stmt->bindValue(":limit", $limit_total, PDO::PARAM_INT);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('NEW 상품 총 개수 조회 실패');
		}

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$total = count($rows); // 30개 이하로만 나옴


		// list 구하기

		$isDisplay = 1;
		$sql = "SELECT * FROM jmmk_goods WHERE isDisplay = :isDisplay ORDER BY regDt DESC LIMIT :limit OFFSET :offset";
		// 신상품 순 30개

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":isDisplay", $isDisplay, PDO::PARAM_INT);
		$stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
		$stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('카테고리로 상품 조회 실패');
		}	

		$list = $stmt->fetchAll(PDO::FETCH_ASSOC);


		// 페이징하기

		$paginator = App::load(\Component\Core\Pagination::class, $page, $limit, $total, $url);

		$pagination = $paginator->getHTML();

		$data = [
			'list' => $list,
			'pagination' => $pagination,
			'total' => $total,
		];

		return $data;
	}

	public function getBestGoods($page, $limit){
		$url = siteUrl("goods/list?category=best");
		$page = $page?$page:1;
		$limit = $limit?$limit:6;
		$offset = ($page - 1) * $limit;


		// total 구하기 (30개 고정이긴 한데 30개보다 적을 수 있으니 구함)

		$isDisplay = 1;
		$limit_total = 30;
		$sql = "SELECT * FROM jmmk_goods WHERE isDisplay = :isDisplay LIMIT :limit";

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":isDisplay", $isDisplay, PDO::PARAM_INT);
		$stmt->bindValue(":limit", $limit_total, PDO::PARAM_INT);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('NEW 상품 총 개수 조회 실패');
		}

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$total = count($rows); // 30개 이하로만 나옴


		// list 구하기

		$isDisplay = 1;
		$sql = "SELECT * FROM jmmk_goods WHERE isDisplay = :isDisplay ORDER BY salePoint DESC LIMIT :limit OFFSET :offset";
		// 신상품 순 30개

		$stmt = db()->prepare($sql);

		$stmt->bindValue(":isDisplay", $isDisplay, PDO::PARAM_INT);
		$stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
		$stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

		$result = $stmt->execute();

		if($result === false){
			throw new AlertException('카테고리로 상품 조회 실패');
		}	

		$list = $stmt->fetchAll(PDO::FETCH_ASSOC);


		// 페이징하기

		$paginator = App::load(\Component\Core\Pagination::class, $page, $limit, $total, $url);

		$pagination = $paginator->getHTML();

		$data = [
			'list' => $list,
			'pagination' => $pagination,
			'total' => $total,
		];

		return $data;
	}
}