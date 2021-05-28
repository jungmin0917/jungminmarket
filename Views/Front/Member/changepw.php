<div class='member_changepw_wrap layout_width'>
	<form method='post' action='indb' target='ifrm_hidden' autocomplete="off" class='member_changepw_form'>
		<input type='hidden' name='mode' value='changepw'>
		<input type='hidden' name='token' value='<?=$token?>'>

		<div class='title'>비밀번호 찾기</div>
		<ul class='member_changepw_ul'>
			<li>
				<label for='memPw'>비밀번호</label>
				<input type='password' name='memPw' id='memPw'>
			</li>
			<li>
				<label for='memPwRe'>비밀번호 확인</label>
				<input type='password' name='memPwRe' id='memPwRe'>
			</li>
		</ul>
		<input type='submit' value='변경하기'>
	</form>
</div>