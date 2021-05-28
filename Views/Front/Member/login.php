<div class='member_login_wrap layout_width'>

<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='member_login_form'>
	<input type='hidden' name='mode' value='login'>
	<div class='member_login_title'>회원 로그인</div>
	<ul class='member_login_ul'>
		<li>
			<label for='memId'>
				<input type='text' name='memId' id='memId' placeholder='아이디'>
			</label>
		</li>
		<li>
			<label for='memPw'>
				<input type='password' name='memPw' id='memPw' placeholder='비밀번호'>
			</label>
		</li>
		<li class='submit'>
			<input type='submit' value='로그인'>
		</li>
		<div class='find_wrap'>
			<li class='find'>
				<a href='<?=siteUrl("member/findid")?>'>아이디 찾기</a>
				<div class='bar'></div>
			</li>
			<li class='find last'>
				<a href='<?=siteUrl("member/findpw")?>'>비밀번호 찾기</a>
			</li>
		</div>
		<li class='join'>
			<a href='<?=siteUrl("member/join")?>'>회원가입</a>
		</li>
	</ul>
	<div class='join_notice'>
		<div class='text1'>아직도 회원이 아니세요?</div>
		<div class='text2'>
			지금 정민마켓의 회원이 되어 다양한 이벤트에 참여해보세요<br>
			회원만의 특별한 혜택을 가장 먼저 만나보세요
		</div>
	</div>
</form>

</div>