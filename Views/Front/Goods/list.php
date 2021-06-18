<section class='goods_list_wrap layout_width'>
	<div class='title'><?=$categoryNm?></div>

	<div class='sub_title'>
	<?php if($category == 'new') : ?>
		따끈따끈한 정민마켓의 신상품을 만나보세요
	<?php endif; ?>


	<?php if($category == 'best') : ?>
		가장 핫한 정민마켓의 베스트 상품을 만나보세요
	<?php endif; ?>
	</div>

	<div class='info_box_wrap'>
		<div class='info_box'>
			<div class='item_count'><span class='count'><?=$goodsCount?></span> items</div>
			<div class='sort_select'>
			<?php if($category !== 'new' && $category !== 'best') : ?>
				<form method='get' action='<?=siteUrl("goods/list?category={$category}")?>' target='_self' autocomplete='off' class='sort_method_form'>
					<input type='hidden' name='category' value='<?=$category?>'>
					<select name='sort_method' class='sort_method'>
						<option value='new' <?php if(!isset($sort) || $sort == 'new'){echo 'selected';}?> >신상품순</option>
						<option value='low_cost' <?php if($sort == 'low_cost'){echo 'selected';}?> >낮은 가격순</option>
						<option value='high_cost' <?php if($sort == 'high_cost'){echo 'selected';}?> >높은 가격순</option>
						<option value='sell_point' <?php if($sort == 'sell_point'){echo 'selected';}?> >판매 점수순</option>
					</select>
				</form>
			<?php endif; ?>
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
					<div class='salePoint_wrap'>
						<span class='salePoint'>판매점수 : <?=$v['salePoint']?></span>
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