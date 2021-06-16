<section class='goods_list_wrap layout_width'>
	<div class='title'><?=$categoryNm?></div>

	<div class='info_box'>
		<div class='item_count'><?=count($goodsList)?> items</div>
	</div>

	<ul class='goods_list_ul'>
		<?php foreach($goodsList as $v) : ?>
			<li>
				<a href='<?=siteUrl("goods/view?goodsNo={$v['goodsNo']}")?>'>
					<?php 
						$file = App::load(\Component\Core\File::class);

						$fileInfo = $file->getGoodsImageFileInfo($v['fileGroup']);

						echo "<img src='/workspace/jungminmarket/assets/Upload/Image/{$fileInfo['fileName']}'>";
					?>
				</a>
			</li>

		<?php endforeach; ?>

	</ul>

</section>