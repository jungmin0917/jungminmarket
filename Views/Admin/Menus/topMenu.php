<div class='top_menu_wrap'>
	<ul class='top_menu_ul layout_width'>
		<li>
			<a href='<?=siteUrl("admin/member")?>' <?php if($topMenuCode == 'member'){echo " class = 'on'";}?> >회원관리</a>
		</li>
		<li>
			<a href='<?=siteUrl("admin/board")?>' <?php if($topMenuCode == 'board'){echo " class = 'on'";}?> >게시판관리</a>
		</li>
		<li>
			<a href='<?=siteUrl("admin/goods")?>' <?php if($topMenuCode == 'goods'){echo " class = 'on'";}?> >상품관리</a>
		</li>
		<li>
			<a href='<?=siteUrl("admin/order")?>' <?php if($topMenuCode == 'order'){echo " class = 'on'";}?> >주문관리</a>
		</li>
	</ul>
</div>