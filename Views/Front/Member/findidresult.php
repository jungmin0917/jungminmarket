<div class='findidresult_wrap layout_width'>
	<div class='findidresult_box'>
		<div class='img'>
			<img src='<?=siteUrl("assets/Front/image/checked.png")?>'>
		</div>

		<div class='info'>
			고객님의 아이디 찾기가 완료되었습니다
		</div>

		<div class='info_box'>
			<ul>
				<li>
					이름 : <?=$memNm?>
				</li>
				<li>
					아이디 : <?=$memId?>
				</li>
				<li>
					가입일 : <?=date("Y-m-d", strtotime($regDt))?>
				</li>
			</ul>
		</div>

		<div class='info_text'>
			고객님의 아이디 찾기가 성공적으로 이루어졌습니다.<br>
			항상 고객님의 즐거운 쇼핑을 위해 최선을 다하겠습니다.
		</div>

		<div class='buttons'>
			<a href='<?=siteUrl("member/login")?>'>로그인</a>

			<a href='<?=siteUrl("member/findpw")?>'>비밀번호 찾기</a>
		</div>
	</div>
</div>