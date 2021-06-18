<section class='goods_view_wrap layout_width'>
	<div class='goods_view_box'>
		<div class='goodsImg'>
			<?php
				$file = App::load(\Component\Core\File::class);

				$fileInfo = $file->getGoodsImageFileInfo($goodsData['fileGroup']);

				echo "<img src='/workspace/jungminmarket/assets/Upload/Image/{$fileInfo['fileName']}'>";
			?>
		</div>

		<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' name='goods_form' id='goods_form' class='goods_form'>
			<input type='hidden' name='mode' value='cart'>
			<input type='hidden' name='goodsNo' value='<?=$goodsData['goodsNo']?>'>
			<div class='goodsInfo'>
				<div class='goodsNm'>
					<div class='stock_info'>
						<?php
							$regTime = strtotime($goodsData['regDt']); // 등록 시간 초로
							$nowTime = strtotime(date("Y-m-d H:i:s")); // 현재 시간 초로
							// 24시간은 86400라고 함
							if(($nowTime - $regTime) < 604800){ // 등록 시간이 일주일 이내일 경우
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
					<div class='goodsName'>
						<?=$goodsData['goodsNm']?>
					</div>
					<div class='shortDesc'>
						<?=$goodsData['shortDesc']?>
					</div>
				</div>
				<div class='price'>
					<div class='title'>판매가</div>
					<div class='content'>
						<span class='defaultPrice'><?=number_format($goodsData['defaultPrice'])?>원</span>
						<span class='salePrice'><?=number_format($goodsData['salePrice'])?>원</span>
						<span class='discount'><span class='discountRate'></span>% OFF</span>
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
						<input type='number' min='1' max='10' value='1' name='goodsCount' class='goods_count_input'> 개
					</div>
					<div class='goods_price'>
						<span class='price_number'></span>원
					</div>
				</div>
				<div class='total'>
					TOTAL : <span class='total_price_wrap'><span class='total_price'></span>원</span>
				</div>

				<div class='buttons'>
					<a href='javascript:;' class='buy_now'>바로구매</a>
					<a href='javascript:;' class='add_cart'>장바구니</a>
					<a href='javascript:;' class='add_wishlist'>관심상품</a>
				</div>
			</div>
		</form>
	</div>

	<div class='longDesc_wrap'>
		<div class='title'>상품 상세정보</div>
		<div class='longDesc'>
			<?php 
				if(!$goodsData['longDesc']){ // 상품 상세정보가 없을 경우
					echo "상품 상세정보가 없습니다";
				}
			?>
			<?=$goodsData['longDesc']?>
		</div>
	</div>

</section>