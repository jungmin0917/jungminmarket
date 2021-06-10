<main class='layout_width'>

<section class='top_banner_wrap'>
	<article class='top_banner'>
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
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

	</article>
</section>

</main>