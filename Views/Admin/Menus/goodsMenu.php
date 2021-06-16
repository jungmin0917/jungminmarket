<div class='sub_menu_wrap'>
	<ul class='sub_menu_ul layout_width'>
		<li>
			<a href='<?=siteUrl("admin/goods/list")?>' <?php if($subMenuCode == 'goods_list'){echo " class='on'";}?> >상품목록</a>
		</li>
		<li>
			<a href='<?=siteUrl("admin/goods/register")?>' <?php if($subMenuCode == 'goods_register'){echo " class='on'";}?> >상품등록</a>
		</li>
		<li>
			<a href='<?=siteUrl("admin/goods/category")?>' <?php if($subMenuCode == 'goods_category'){echo " class='on'";}?> >분류설정</a>
		</li>
		<?php if($subMenuCode == 'goods_update') : ?>
		<li>
			<a class='on'>상품수정중</a>
		</li>
		<?php endif; ?>
	</ul>
</div>