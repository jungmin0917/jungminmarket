<main class='layout_width'>

<aside>
	<span class='go_top'><i class='xi-arrow-up'></i></span>
	<span class='go_down'><i class='xi-arrow-down'></i></span>
</aside>

<section class='top_banner_wrap'>
	<article class='top_banner'>
		<div class="swiper-container mySwiper_banner">
			<div class="swiper-wrapper">
				<?php foreach($bannerImageList as $v) : ?>
					<div class="swiper-slide banner">
						<img src='/workspace/jungminmarket/assets/Upload/Image/<?=$v['fileName']?>'>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="swiper-pagination"></div>
		</div>
		<div class="swiper-button-next button"></div>
		<div class="swiper-button-prev button"></div>
	</article>
</section>

<section class='main_board_wrap'>
	<article class='board_box'>
		<div class='notice_board board'>
			<a href='<?=siteUrl("board/list?id={$notice_list['boardId']}")?>' class='title_box'>
				<div class='left'><i class='xi-bell-o'></i><?=$notice_list['boardNm']?></div>
				<div class='right'><i class='xi-plus-thin'></i></div>
			</a>
			<div class='list_box'>
				<ul>
					<?php foreach($notice_list['list'] as $v) : ?>
						<li>
							<a href='<?=siteUrl("board/view?id={$notice_list['boardId']}&post={$v['postNo']}")?>'><?=$v['subject']?></a>
							<a href='<?=siteUrl("board/view?id={$notice_list['boardId']}&post={$v['postNo']}#comment_list_box")?>'>
							<?php
								$comment = App::load(\Component\Comment\Comment::class);

								$amount = count($comment->getList($v['postNo']));

								if($amount){
									echo "[".$amount."]";
								}
							?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

		<div class='event_board board'>
			<a href='<?=siteUrl("board/list?id={$event_list['boardId']}")?>' class='title_box'>
				<div class='left'><i class='xi-star-o'></i><?=$event_list['boardNm']?></div>
				<div class='right'><i class='xi-plus-thin'></i></div>
			</a>
			<div class='list_box'>
				<ul>
					<?php foreach($event_list['list'] as $v) : ?>
						<li>
							<a href='<?=siteUrl("board/view?id={$event_list['boardId']}&post={$v['postNo']}")?>'><?=$v['subject']?></a>
							<a href='<?=siteUrl("board/view?id={$event_list['boardId']}&post={$v['postNo']}#comment_list_box")?>'>
							<?php
								$comment = App::load(\Component\Comment\Comment::class);

								$amount = count($comment->getList($v['postNo']));

								if($amount){
									echo "[".$amount."]";
								}
							?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

	</article>
</section>

<section class='best_item_wrap'>
	<article class='best_item_box'>
		<div class='title'>베스트 상품</div>
		<div class='sub_title'>이달의 인기상품을 확인해보세요</div>
		<div class='mySwiper_best_wrap'>
			<div class="swiper-container mySwiper_best">
				<div class="swiper-wrapper">
					<?php foreach($bestGoodsList as $v) : ?>
						<?php
							$file = App::load(\Component\Core\File::class);

							$fileInfo = $file->getGoodsImageFileInfo($v['fileGroup']);

							$fileName = $fileInfo['fileName'];
						?>
						<div class="swiper-slide banner">
							<a href='<?=siteUrl("goods/view?goodsNo={$v['goodsNo']}")?>'>
								<div class='overlay'>
									<div class='goods_info'>
										<span class='goods_title'><?=$v['goodsNm']?><br></span>
										<?=number_format($v['salePrice'])?>원<br>
										판매 점수 <?=$v['salePoint']?>
									</div>
								</div>
								<img src='/workspace/jungminmarket/assets/Upload/Image/<?=$fileName?>'>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
			<div class="swiper-button-next button"></div>
			<div class="swiper-button-prev button"></div>
		</div>

		<a href='<?=siteUrl("goods/list?category=best")?>' class='more_button'>더 보기</a>
	</article>
</section>


<section class='new_item_wrap'>
	<article class='new_item_box'>
		<div class='title'>신상품</div>
		<div class='sub_title'>매주 업데이트되는 신상품을 만나보세요</div>

		<ul class='new_item_ul'>
			<?php foreach($newGoodsList as $v) : ?>
				<?php
					$file = App::load(\Component\Core\File::class);

					$fileInfo = $file->getGoodsImageFileInfo($v['fileGroup']);

					$fileName = $fileInfo['fileName'];
				?>
				<li>
					<a href='<?=siteUrl("goods/view?goodsNo={$v['goodsNo']}")?>'>
						<div class='goodsImage'>
							<div class='overlay'></div>
							<img src='/workspace/jungminmarket/assets/Upload/Image/<?=$fileName?>'>
						</div>
						<div class='goodsNm'>
							<?=$v['goodsNm']?>
						</div>
					</a>
					<div class='shortDesc'><?=$v['shortDesc']?></div>
					<div class='goodsPrice'>
						<span class='defaultPrice'><?=number_format($v['defaultPrice'])?>원</span>
						<span class='salePrice'><?=number_format($v['salePrice'])?>원</span>
					</div>
					<div class='date_info'>
						<span class='date_ago'>
							<?php
								$regTime = strtotime($v['regDt']);
								$nowTime = strtotime(date("Y-m-d H:i:s"));

								$second = $nowTime - $regTime;

								$day = floor($second / 86400);

								if($day > 0){
									echo $day."일 전";
								}else{
									echo "오늘";
								}
							?>
						</span>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<a href='<?=siteUrl("goods/list?category=new")?>' class='more_button'>더 보기</a>
	</article>
</section>

</main>