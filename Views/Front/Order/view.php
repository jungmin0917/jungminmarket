<div class='order_view_wrap layout_width'>
	<div class='title'>주문상세</div>

	<div class='orderDateAndNo'>
		<span class='orderDate'><?=date("Y. m. d", strtotime($orderData['regDt']))?> 주문</span>
		<span class='orderNo'>(주문번호 : <?=$orderData['orderNo']?>)</span>
	</div>

	<div class='order_view_box'>
		<div class='sub_title'>주문 상품</div>


		<div class='order_view_table_wrap'>
			<table class='order_view_table'>
				<thead>
					<tr>
						<th colspan='2' width='50%'>상품명</th>
						<th width='20%'>수량</th>
						<th width='30%'>금액</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($orderGoods as $k => $v) : ?>
					<tr>
						<td width='9%' class='goodsImg'>
							<?php
								$file = App::load(\Component\Core\File::class);

								$goods = App::load(\Component\Goods\Goods::class);

								$goodsData = $goods->getGoods($v['goodsNo']);

								$fileInfo = $file->getGoodsImageFileInfo($goodsData['fileGroup']);

								echo "<img src='/workspace/jungminmarket/assets/Upload/Image/{$fileInfo['fileName']}'>";
							?>
						</td>
						<td class='goodsNm'>
							<?=$v['goodsNm']?>
						</td>
						<td class='goodsCount'>
							<?=$v['goodsCount']?>
						</td>
						<td class='totalPrice'>
							<?=number_format($v['goodsCount'] * $v['salePrice'])?>원
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan='2' width='30%'>
							총 합계
						</th>
						<th width='20%'>
							배송비
						</th>
						<th width='50%'>
							최종
						</th>
					</tr>
					<tr>
						<td class='totalPrice' colspan='2' width='30%'>
							<?=number_format($totalPrice)?>원
						</td>
						<td class='deliveryFee' width='20%'>
							<?=number_format($deliveryFee)?>원
						</td>
						<td class='finalPrice' width='50%'>
							<?=number_format($totalPrice + $deliveryFee)?>원
						</td>
					</tr>
				</tfoot>
			</table>
		</div>


		<div class='sub_title'>주문자 정보</div>
		<div class='order_info_box'>
			<ul class='order_info_ul'>
				<li>
					<label for='orderName'>주문자 이름</label>
					<div><?=$orderData['orderName']?></div>
				</li>
				<li>
					<label for='orderPhone'>주문자 전화번호</label>
					<div><?=$orderData['orderPhone']?></div>

				</li>
				<li>
					<label for='orderEmail'>주문자 이메일</label>
					<div><?=$orderData['orderEmail']?></div>
				</li>
			</ul>
		</div>

		<div class='sub_title'>배송지 정보</div>
		
		<div class='receiver_info_box'>
			<ul class='receiver_info_ul'>
				<li>
					<label for='receiverName'>수신자 이름</label>
					<div><?=$orderData['receiverName']?></div>
				</li>
				<li>
					<label for='receiverPhone'>수신자 전화번호</label>
					<div><?=$orderData['receiverPhone']?></div>
				</li>
				<li>
					<label for='receiverAd'>수신자 주소</label>
					<div>
						<div>(<?=$orderData['receiverAdNum']?>) <?=$orderData['receiverAdMain']?> <?=$orderData['receiverAdRemain']?></div>
					</div>
				</li>
			</ul>
		</div>

		<div class='sub_title'>결제 정보</div>
		<div class='payment_info_box'>
			<ul class='payment_info_ul'>
				<li>
					<label>주문상품 금액</label>
					<div><?=number_format($totalPrice)?>원</div>
				</li>
				<li>
					<label>배송비</label>
					<div><?=number_format($deliveryFee)?>원</div>
				</li>
				<li>
					<label>결제금액</label>
					<div class='finalPrice'><?=number_format($totalPrice + $deliveryFee)?>원</div>
				</li>
				<li>
					<label>결제수단</label>
					<div><?=$orderData['paymentMethod']?></div>
				</li>
				<?php if($orderData['paymentMethod'] == '무통장입금') : ?>
				<li>
					<label>입금계좌</label>
					<div>
						<div>
							<?php 
								if($orderData['bankAccount'] == 'shinhan'){
									echo "신한 110-354-937017 황정민";
								}else if($orderData['bankAccount'] == 'nonghyup'){
									echo "농협 123-456-789012 황정민";
								}else{

								}
							?>
						</div>
						<div>
							입금자명 : <?=$orderData['bankDepositor']?>
						</div>
					</div>
				</li>
				<?php endif; ?>
			</ul>
		</div>

	</div>
</div>