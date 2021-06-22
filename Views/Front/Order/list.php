<div class='order_list_wrap layout_width'>
	<div class='title'>주문내역</div>

	<?php if(!$orderList) : ?>
	<div class='no_order_info'>
		주문내역이 존재하지 않습니다
	</div>
	<?php endif; ?>

	<div class='order_list_box'>
		<?php foreach($orderList as $k => $v) : ?>
			<ul class='order_list_ul'>
				<div class='orderTitle'>
					<div class='orderDate'><?=date("Y. m. d.", strtotime($v['regDt']))?> 주문 <span class='orderNo'>(주문번호 : <?=$v['orderNo']?>)</span></div>
					<div class='orderDetail'><a href='<?=siteUrl("order/view?orderNo={$v['orderNo']}")?>'>주문 상세 보기<i class='xi-angle-right-min'></i></a></div>
				</div>
				<?php foreach($v['orderGoodsList'] as $k2 => $v2) : ?>
					<li class='order_list_li'>
						<div class='orderStatus'><?=$v['orderStatus']?></div>
						<div class='goodsImg'>
							<?php
								$goods = App::load(\Component\Goods\Goods::class);

								$file = App::load(\Component\Core\File::class);

								$goodsInfo = $goods->getGoods($v2['goodsNo']);

								$fileInfo = $file->getGoodsImageFileInfo($goodsInfo['fileGroup']);

								$fileName = $fileInfo['fileName'];

								echo "<img src='/workspace/jungminmarket/assets/Upload/Image/{$fileName}'>";
							?>
						</div>
						<div class='goodsInfo'>
							<div class='goodsNm'><?=$v2['goodsNm']?></div>
							<div class='goodsPrice'>
								<span class='salePrice'><?=number_format($v2['salePrice'])?>원</span>, <span class='goodsCount'><?=$v2['goodsCount']?>개</span>
							</div>
							<div class='totalGoodsPrice'>총 <?=number_format($v2['totalGoodsPrice'])?>원</div>
						</div>
					</li>
				<?php endforeach; ?>

			</ul>
		<?php endforeach; ?>

	</div>
	<?=$pagination?>
</div>