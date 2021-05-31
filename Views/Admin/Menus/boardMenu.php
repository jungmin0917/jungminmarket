<div class='sub_menu_wrap'>
	<ul class='sub_menu_ul layout_width'>
		<li>
			<a href='<?=siteUrl("admin/board/list")?>' <?php if($subMenuCode == 'board_list'){echo " class='on'";}?> >게시판목록</a>
		</li>
		<li>
			<a href='<?=siteUrl("admin/board/create")?>' <?php if($subMenuCode == 'board_create'){echo " class='on'";}?> >게시판생성</a>
		</li>
		<li>
			<a href='<?=siteUrl("admin/board/banner")?>' <?php if($subMenuCode == 'board_banner'){echo " class='on'";}?> >배너설정</a>
		</li>
	</ul>
</div>