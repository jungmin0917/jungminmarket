<div class='etc_temporary_wrap layout_width'>
	<div class='title'>임시파일 지우기</div>
	<form method='post' action='<?=siteUrl("file/deleteTemporary")?>' target='ifrm_hidden' autocomplete='off'>
		<input type='submit' value='임시파일 지우기' onclick="return confirm('정말 지우시겠습니까?');">
	</form>
</div>