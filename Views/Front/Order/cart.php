<section class='order_cart_wrap layout_width'>
	<div class='title'>장바구니</div>

	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='order_cart_form'>
		<input type='hidden' name='mode' value='order'>
		<div class='order_cart_table_wrap'>
			<table class='order_cart_table'>
				<thead>
					<tr>
						<th width='5%'>선택</th>
						<th colspan='2' width='45%'>상품정보</th>
						<th width='10%'>수량</th>
						<th width='15%'>금액</th>
						<th width='12.5%'>포인트</th>
						<th width='12.5%'>관리</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach($cartList as $v) : ?>
					<tr>
						<td class='cartNo'>
							<input type='checkbox' name='cartNo[]' value='<?=$v['cartNo']?>' class='cartNo_input' checked
								<?php
									// goodsNo로 goods DB에서 salePrice 가져와야 함

									$goodsNo = $v['goodsNo'];

									$goods = App::load(\Component\Goods\Goods::class);

									$goodsData = $goods->getGoods($goodsNo);

									$price = $goodsData['salePrice'];

									echo " data-price='{$price}'";
								?>
							>
						</td>
						<td class='goodsImg' width='9%'>
							<?php
								// goodsNo로 fileGroup 구한 후 이미지 가져오기
								$goods = App::load(\Component\Goods\Goods::class);
								$file = App::load(\Component\Core\File::class);

								$goodsInfo = $goods->getGoods($v['goodsNo']);

								$fileGroup = $goodsInfo['fileGroup'];

								$fileInfo = $file->getGoodsImageFileInfo($fileGroup);

								echo "<img src='/workspace/jungminmarket/assets/Upload/Image/{$fileInfo['fileName']}'>";
							?>
						</td>
						<td class='goodsNm'>
							<?php
								$goods = App::load(\Component\Goods\Goods::class);

								$goodsData = $goods->getGoods($v['goodsNo']);

								echo $goodsData['goodsNm'];
							?>
						</td>
						<td class='goodsCount'>
							<input type='number' value='<?=$v['goodsCount']?>' min='1' max='10' class='goods_count_input'>개
						</td>
						<td class='goodsTotalPrice'>
							<span class='price'></span>원
						</td>
						<td class='rewardPoint'>
							<span class='price'></span>원
						</td>
						<td class='buttons'>
							<a href='<?=siteUrl("order/order?cartNo={$v['cartNo']}")?>'>주문하기</a>
							<a href='<?=siteUrl("order/delete?cartNo={$v['cartNo']}")?>' class='delete' onclick="return confirm('정말 삭제하시겠습니까?');"><i class='xi-close'></i>삭제</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</form>

	<div class='order_cart_price_wrap'>
		<table class='order_cart_price_table'>
			<thead>
				<tr>
					<th width='35%'>총 상품 금액</th>
					<th width='25%'>배송비</th>
					<th width='40%'>결제 금액</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td class='total_price'></td>
					<td class='delivery_fee'></td>
					<td class='final_price'></td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class='order_buttons'>
		<a href='javascript:;' class='order_all'>전체상품 주문</a>
		<a href='javascript:;' class='order_select'>선택상품 주문</a>
		<a href='javascript:;' class='remove_select'>선택상품 삭제</a>
		<a href='javascript:;' class='remove_all'>장바구니 비우기</a>
	</div>
</section>