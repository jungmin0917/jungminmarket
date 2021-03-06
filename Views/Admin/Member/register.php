<div class='member_register_wrap layout_width'>
	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='member_register_form'>
	<div class='member_register_title'>관리자 등록<span class='required'>(* 표시는 필수 입력)</span></div>
		<input type='hidden' name='mode' value='<?php if(isset($memNo)){echo "modify";}else{echo "register";}?>'>
		<ul class='member_register_ul'>
			<li>
				<label for='memId'>아이디<span class='required'>*</span></label>
				<input type='text' name='memId' id='memId' class='<?php if(!isset($memNo)){echo "input_validator";}?>' value='<?php if(isset($memNo)){echo $memId;}?>' <?php if(isset($memNo)){echo "readonly";}?> >
			</li>
			<li>
				<label for='memPw'>비밀번호<span class='required'>*</span></label>
				<input type='password' name='memPw' id='memPw' class='input_validator'>
			</li>
			<li>
				<label for='memPwRe'>비밀번호 확인<span class='required'>*</span></label>
				<input type='password' name='memPwRe' id='memPwRe' class='input_validator'>
			</li>
			<li>
				<label for='memNm'>이름<span class='required'>*</span></label>
				<input type='text' name='memNm' id='memNm' value='<?php if(isset($memNo)){echo $memNm;}?>'>
			</li>
			<li>
				<label for='memAd_search'>주소<span class='required'>*</span></label>
				<ul class='memAd_ul'>
					<li>
						<input type='text' name='memAdNum' id='memAdNum' placeholder='우편번호' value='<?php if(isset($memNo)){echo $memAdNum;}?>' readonly>
						<input type='button' value='주소검색' id='memAd_search'>
					</li>
					<li>
						<input type='text' name='memAdMain' id='memAdMain' placeholder='기본주소' value='<?php if(isset($memNo)){echo $memAdMain;}?>' readonly>
					</li>
					<li>
						<input type='text' name='memAdRemain' id='memAdRemain' placeholder='나머지 주소' value='<?php if(isset($memNo)){echo $memAdRemain;}?>'>
					</li>
				</ul>
			</li>
			<li>
				<?php 
					if(isset($memNo)){
						$memPhArray = explode("-", $memPh);
					}
				?>
				<label for='memPh'>전화번호<span class='required'>*</span></label>
				<select id='memPh_1' name='memPh[]'>
					<option value='010' <?php if(isset($memPhArray) && $memPhArray[0] == '010'){echo 'selected';}?> >010</option>
					<option value='011' <?php if(isset($memPhArray) && $memPhArray[0] == '011'){echo 'selected';}?> >011</option>
					<option value='016' <?php if(isset($memPhArray) && $memPhArray[0] == '016'){echo 'selected';}?> >016</option>
					<option value='017' <?php if(isset($memPhArray) && $memPhArray[0] == '017'){echo 'selected';}?> >017</option>
					<option value='018' <?php if(isset($memPhArray) && $memPhArray[0] == '018'){echo 'selected';}?> >018</option>
					<option value='019' <?php if(isset($memPhArray) && $memPhArray[0] == '019'){echo 'selected';}?> >019</option>
				</select>
				<input id='memPh_2' name='memPh[]' maxlength='4' class='memPh' value='<?php if(isset($memNo)){echo $memPhArray[1];}?>'>
				<input id='memPh_3' name='memPh[]' maxlength='4' class='memPh' value='<?php if(isset($memNo)){echo $memPhArray[2];}?>'>
			</li>
			<li>
				<label for='memEm'>이메일<span class='required'>*</span></label>
				<input type='email' name='memEm' id='memEm' value='<?php if(isset($memNo)){echo $memEm;}?>'>
			</li>
		</ul>
		<div class='member_register_submit_wrap'>
			<input type='submit' value='<?php if(isset($memNo)){echo "회원정보 수정";}else{echo "관리자 등록";}?>'>
		</div>
	</form>
</div>