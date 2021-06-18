<section class='goods_list_wrap layout_width'>
	<div class='title'><?=$categoryNm?></div>

	<div class='info_box_wrap'>
		<div class='info_box'>
			<div class='item_count'><span class='count'><?=$goodsCount?></span> items</div>
			<div class='sort_select'>
				<select name='sort_method'>
					<option value='new'>신상품순</option>
					<option value='low_cost'>낮은 가격순</option>
					<option value='high_cost'>높은 가격순</option>
				</select>
			</div>
		</div>
	</div>

	<div class='goods_list_ul_wrap'>
		<ul class='goods_list_ul'>
			<?php foreach($goodsList as $v) : ?>
				<li>
					<a href='<?=siteUrl("goods/view?goodsNo={$v['goodsNo']}")?>' class='goodsImg'>
						<?php 
							$file = App::load(\Component\Core\File::class);

							$fileInfo = $file->getGoodsImageFileInfo($v['fileGroup']);

							echo "<img src='/workspace/jungminmarket/assets/Upload/Image/{$fileInfo['fileName']}'>";
						?>
					</a>
					<div class='goodsNm'><a href='<?=siteUrl("goods/view?goodsNo={$v['goodsNo']}")?>'><?=$v['goodsNm']?></a></div>
					<div class='shortDesc'><?=$v['shortDesc']?></div>
					<div class='price'>
						<span class='defaultPrice'><?=number_format($v['defaultPrice'])?>원</span> <span class='salePrice'><?=number_format($v['salePrice'])?>원</span>
					</div>
					<div class='stock_info'>
						<?php
							$regTime = strtotime($v['regDt']); // 등록 시간 초로
							$nowTime = strtotime(date("Y-m-d H:i:s")); // 현재 시간 초로
							// 24시간은 86400라고 함
							// 일주일은 604800
							if(($nowTime - $regTime) < 604800){ // 등록 시간이 일주일 이내일 경우
								echo "<span class='new_item'>신상품</span>";
							}
						?>

						<?php if($v['stock'] <= 10) : ?>
							<span class='low_in_stock'>품절임박</span>
						<?php endif; ?>

						<?php if($v['isSoldout'] == 1) : ?>
							<span class='soldout'>품절됨</span>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

	<?=$pagination?>

</section>