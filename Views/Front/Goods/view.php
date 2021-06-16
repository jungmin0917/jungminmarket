<section class='goods_view_wrap layout_width'>
	<div class='goods_view_box'>
		<div class='goodsImg'>
			<?php
				$file = App::load(\Component\Core\File::class);

				$fileInfo = $file->getGoodsImageFileInfo($goodsData['fileGroup']);

				echo "<img src='/workspace/jungminmarket/assets/Upload/Image/{$fileInfo['fileName']}'>";
			?>
		</div>

		<div class='goodsInfo'>
			<div class='goodsNm'>
				<?=$goodsData['goodsNm']?>
				<div class='stock_info'>
					<?php
						$regTime = strtotime($goodsData['regDt']); // 등록 시간 초로
						$nowTime = strtotime(date("Y-m-d H:i:s")); // 현재 시간 초로
						// 1시간은 86400라고 함
						if(($nowTime - $regTime) < 86400){ // 등록 시간이 24시간 이내일 경우
							echo "<span class='new_item'>신상품</span>";
						}
					?>

					<?php if($goodsData['stock'] <= 10) : ?>
						<span class='low_in_stock'>품절임박</span>
					<?php endif; ?>

					<?php if($goodsData['isSoldout'] == 1) : ?>
						<span class='soldout'>품절됨</span>
					<?php endif; ?>
				</div>
			</div>
			<div class='price'>
				<div class='title'>판매가</div>
				<div class='content'>
					<span class='defaultPrice'><?=number_format($goodsData['defaultPrice'])?>원</span>
					<span class='salePrice'><?=number_format($goodsData['salePrice'])?>원</span>
				</div>
			</div>
			<div class='option'>
				<div class='title'>옵션</div>
				<?php if(!$goodsData['options']) : ?>
					<div class='option_info'>해당 상품은 옵션이 없습니다</div>
				<?php endif; ?>
			</div>
			<div class='item_count'>
				<div class='goods_name'>
					<?=$goodsData['goodsNm']?>
				</div>
				<div class='goods_count'>
					<input type='number' min='0' max='10'> 개
				</div>
				<div class='total_price'>

				</div>
			</div>
		</div>
	</div>

</section>