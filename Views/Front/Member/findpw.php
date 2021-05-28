<div class='member_findpw_wrap layout_width'>
	<div class='member_findpw_text1'>
		비밀번호 찾기
	</div>
	<div class='member_findpw_text2'>
		이메일로 찾기가 가능합니다.<br>
		수신 가능한 이메일을 이용해주세요.
	</div>

	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='member_findpw_form'>
		<input type='hidden' name='mode' value='findpw'>
		<div class='title'>비밀번호 찾기</div>
		<ul class='member_findpw_ul'>
			<li>
				<label for='memId'>아이디</label>
				<input type='text' id='memId' name='memId'>
			</li>
			<li>
				<label for='memNm'>이름</label>
				<input type='text' id='memNm' name='memNm'>
			</li>
			<li>
				<label for='memEm'>이메일</label>
				<input type='text' id='memEm' name='memEm'>
			</li>
		</ul>
		<input type='submit' value='찾기'>
	</form>

</div>