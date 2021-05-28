<div class='sub_menu_wrap'>
	<ul class='sub_menu_ul layout_width'>
		<li>
			<a href='<?=siteUrl("admin/goods/list")?>' <?php if($subMenuCode == 'goods_list'){echo " class='on'";}?> >상품목록</a>
		</li>
		<li>
			<a href='<?=siteUrl("admin/goods/register")?>' <?php if($subMenuCode == 'goods_register'){echo " class='on'";}?> >상품등록</a>
		</li>
	</ul>
</div>