<?php

namespace Component\Order;

use App;
use PDO;
use Component\Exception\AlertException;

class Order{

	private $params = [];

	public function data($params = []){
		$this->params = $params;

		return $this;
	}

	public function validator($mode){
		switch($mode){
			case 'order':
				if(!$this->params['orderName']){
					throw new AlertException('주문자 이름을 입력해주세요');
				}
				foreach($this->params['orderPhone'] as $v){
					if(!$v){
						throw new AlertException('주문자 전화번호를 입력해주세요');
					}
				}
				if(!$this->params['orderEmail']){
					throw new AlertException('주문자 이메일을 입력해주세요');
				}
				if(!$this->params['receiverName']){
					throw new AlertException('수신자 이름을 입력해주세요');
				}
				foreach($this->params['receiverPhone'] as $v){
					if(!$v){
						throw new AlertException('수신자 전화번호를 입력해주세요');
					}
				}
				if(!$this->params['receiverAdNum']){
					throw new AlertException('수신자 주소를 입력해주세요');
				}
				if(!$this->params['receiverAdMain']){
					throw new AlertException('수신자 주소를 입력해주세요');
				}
				if(!$this->params['receiverAdRemain']){
					throw new AlertException('수신자 주소를 입력해주세요');
				}
				if($this->params['paymentMethod'] == '무통장입금'){
					if(!$this->params['bankDepositor']){
						throw new AlertException('입금자명을 입력해주세요');
					}
				}

				$this->orderNameValidate();
				$this->orderPhoneValidate();
				$this->orderEmailValidate();
				$this->receiverNameValidate();
				$this->receiverPhoneValidate();

				if($this->params['paymentMethod'] == '무통장입금'){
					$this->bankDepositorValidate();
				}

				break;

			default:
				break;
		}

		return $this;
	}

	public function orderNameValidate(){
		$orderName = $this->params['orderName'];

		if(preg_match("/[^가-힣]/", $orderName) || mb_strlen($orderName) > 10){
			throw new AlertException('주문자 이름은 한글 10자 이내로 입력해주세요');
		}
	}

	public function orderPhoneValidate(){
		if(strlen($this->params['orderPhone'][1]) < 3 || strlen($this->params['orderPhone'][1]) > 4 || strlen($this->params['orderPhone'][2]) != 4 || preg_match("/[^0-9]/", $this->params['orderPhone'][1]) || preg_match("/[^0-9]/", $this->params['orderPhone'][2])){

			throw new AlertException('주문자 전화번호를 올바로 입력해주세요');
		}
	}

	public function orderEmailValidate(){
		$orderEmail = $this->params['orderEmail'];

		$result = filter_var($orderEmail, FILTER_VALIDATE_EMAIL);

		if($result === false){
			throw new AlertException('이메일을 올바르게 입력해주세요');
		}
	}

	public function receiverNameValidate(){
		$receiverName = $this->params['receiverName'];

		if(preg_match("/[^가-힣]/", $receiverName) || mb_strlen($receiverName) > 10){
			throw new AlertException('수신자 이름은 한글 10자 이내로 입력해주세요');
		}
	}

	public function receiverPhoneValidate(){
		if(strlen($this->params['receiverPhone'][1]) < 3 || strlen($this->params['receiverPhone'][1]) > 4 || strlen($this->params['receiverPhone'][2]) != 4 || preg_match("/[^0-9]/", $this->params['receiverPhone'][1]) || preg_match("/[^0-9]/", $this->params['receiverPhone'][2])){

			throw new AlertException('수신자 전화번호를 올바로 입력해주세요');
		}
	}

	public function bankDepositorValidate(){
		$bankDepositor = $this->params['bankDepositor'];

		if(preg_match("/[^가-힣]/", $bankDepositor) || mb_strlen($bankDepositor) > 10){
			throw new AlertException('수신자 이름은 한글 10자 이내로 입력해주세요');
		}
	}

	public function order(){
		try{

			// order에 sql 작업 한 후 order_goods에 sql 작업해야 함

			// 트랜잭션 처리
			db()->beginTransaction();

			// order 작업
			$memNo = getSession('member_memNo');
			$orderName = $this->params['orderName'];
			$orderPhone = implode("-", $this->params['orderPhone']);
			$orderEmail = $this->params['orderEmail'];
			$receiverName = $this->params['receiverName'];
			$receiverPhone = implode("-", $this->params['receiverPhone']);
			$receiverAdNum = $this->params['receiverAdNum'];
			$receiverAdMain = $this->params['receiverAdMain'];
			$receiverAdRemain = $this->params['receiverAdRemain'];
			$paymentMethod = $this->params['paymentMethod'];
			$bankAccount = $this->params['bankAccount'];
			$bankDepositor = $this->params['bankDepositor'];


			$sql = "INSERT INTO jmmk_order (memNo, orderName, orderPhone, orderEmail, receiverName, receiverPhone, receiverAdNum, receiverAdMain, receiverAdRemain, paymentMethod, bankAccount, bankDepositor) VALUES (:memNo, :orderName, :orderPhone, :orderEmail, :receiverName, :receiverPhone, :receiverAdNum, :receiverAdMain, :receiverAdRemain, :paymentMethod, :bankAccount, :bankDepositor)";

			$stmt = db()->prepare($sql);

			$bindData = ['memNo', 'orderName', 'orderPhone', 'orderEmail', 'receiverName', 'receiverPhone', 'receiverAdNum', 'receiverAdMain', 'receiverAdRemain', 'paymentMethod', 'bankAccount', 'bankDepositor'];

			foreach($bindData as $v){
				$stmt->bindValue("{$v}", $$v);
			}

			$result = $stmt->execute();


			// 여기부터는 order_goods 작업

			if($result){
				$orderNo = db()->lastInsertId();
			}

			$goods = App::load(\Component\Goods\Goods::class);

			$cartData = [];

			foreach($this->params['cartNo'] as $v){
				$cartData[] = $goods->getCart($v); 
			}

			foreach($cartData as $k => $v){
				$sql = "INSERT INTO jmmk_order_goods (orderNo, goodsNo, goodsNm, goodsCount, salePrice, totalGoodsPrice) VALUES (:orderNo, :goodsNo, :goodsNm, :goodsCount, :salePrice, :totalGoodsPrice)";

				$goodsData = $goods->getGoods($v['goodsNo']);

				$goodsNo = $v['goodsNo'];
				$goodsNm = $goodsData['goodsNm'];
				$goodsCount = $v['goodsCount'];
				$salePrice = $goodsData['salePrice'];
				$totalGoodsPrice = $goodsCount * $salePrice;

				$stmt = db()->prepare($sql);

				$bindData = ['orderNo', 'goodsNo', 'goodsNm', 'goodsCount', 'salePrice', 'totalGoodsPrice'];

				foreach($bindData as $v){
					$stmt->bindValue(":{$v}", $$v);
				}

				$result = $stmt->execute();
			}

			
			// 여기부터는 주문 성공한 상품 장바구니에서 제거 작업

			// 바로구매가 아니면 장바구니에서 주문한 물품 삭제
			foreach($cartData as $k => $v){
				if($v['isDirect'] != 1){
					$goods->deleteCart($v['cartNo']);
				}
			}

			db()->commit();
			return true;
		}catch(PDOException $e){
			db()->rollback();
			return false;
		}
	}

	public function getOrder($memNo){
		
	}
}