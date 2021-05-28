<div class='sub_menu_wrap'>
	<ul class='sub_menu_ul layout_width'>
		<li>
			<a href='<?=siteUrl("admin/member/list")?>' <?php if($subMenuCode == 'member_list'){echo " class='on'";}?> >회원목록</a>
		</li>
		<li>
			<a href='<?=siteUrl("admin/member/register")?>' <?php if($subMenuCode == 'member_register'){echo " class='on'";}?> >관리자등록</a>
		</li>
		<li>
			<a href='<?=siteUrl("admin/member/config")?>' <?php if($subMenuCode == 'member_config'){echo " class='on'";}?> >가입설정</a>
		</li>
	</ul>
</div>