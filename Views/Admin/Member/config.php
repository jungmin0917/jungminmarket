<div class='member_config_wrap layout_width'>
	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='member_config_form'>
		<input type='hidden' name='mode' value='terms'>
		<div class='title'>회원가입 약관 설정</div>
		<ul class='member_config_ul'>
			<li>
				<label for='terms1'>회원약관</label>
				<textarea id='terms1' name='terms1'><?=$terms1?></textarea>
			</li>
			<li>
				<label for='terms2'>개인정보 이용 동의</label>
				<textarea id='terms2' name='terms2'><?=$terms2?></textarea>
			</li>
			<li>
				<label for='terms3'>쇼핑정보 수집 동의</label>
				<textarea id='terms3' name='terms3'><?=$terms3?></textarea>
			</li>
		</ul>
		<input type='submit' value='저장하기'>
	</form>
</div>