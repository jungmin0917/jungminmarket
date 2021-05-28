<div class='member_findid_wrap layout_width'>
	<div class='member_findid_text1'>
		아이디 찾기
	</div>
	<div class='member_findid_text2'>
		가입하신 방법에 따라 아이디 찾기가 가능합니다.<br>
		이메일 또는 전화번호를 이용해주세요.
	</div>
	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='member_findid_form'>
		<input type='hidden' name='mode' value='findid'>
		<div class='title'>아이디 찾기</div>
		<ul class='member_findid_ul'>
			<li class='find_method'>
				<div class='left'>방법</div>
				<div class='right'>
					<label for='email'>
					<input type='radio' name='find_method' value='email' id='email' checked>
					이메일</label>
				</div>
				<div class='right'>
					<label for='phone'>
					<input type='radio' name='find_method' value='phone' id='phone'>
					전화번호</label>
				</div>
			</li>
			<li>
				<label for='memNm'>이름</label>
				<input type='text' id='memNm' name='memNm'>
			</li>
			<li class='email'>
				<label for='memEm'>이메일</label>
				<input type='text' id='memEm' name='memEm'>
			</li>
			<li class='phone none'>
				<label for='memPh'>전화번호</label>
				<input type='text' id='memPh' name='memPh[0]' maxlength='3'>
				<input type='text' id='memPh' name='memPh[1]' maxlength='4'>
				<input type='text' id='memPh' name='memPh[2]' maxlength='4'>
			</li>
		</ul>
		<input type='submit' value='찾기'>
	</form>
</div>