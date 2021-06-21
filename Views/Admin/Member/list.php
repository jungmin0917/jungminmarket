<div class='member_list_wrap layout_width'>
	<div class='title'>회원 목록</div>
	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='member_list_form'>
		<input type='hidden' name='mode' value='updateGrade'>
		<table class='member_list_table'>
			<thead>
				<tr>
					<th width='5%'>선택</th>
					<th width='8%'>회원등급</th>
					<th width='15%'>아이디</th>
					<th width='10%'>이름</th>
					<th width='30%'>주소</th>
					<th width='12%'>전화번호</th>
					<th width='20%'>이메일</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($list as $v) : ?>
					<tr>
						<td><input type='checkbox' name=memNo[<?=$v['memNo']?>]></td>
						<td>
							<?php if($v['memLv'] != 10) : ?>
							<select name=memLv[<?=$v['memNo']?>]>
								<option value='0' <?php if($v['memLv'] == '0'){echo "selected";}?> >일반</option>
								<option value='1' <?php if($v['memLv'] == '1'){echo "selected";}?> >패밀리</option>
								<option value='2' <?php if($v['memLv'] == '2'){echo "selected";}?> >VIP</option>
								<option value='3' <?php if($v['memLv'] == '3'){echo "selected";}?> >VVIP</option>
							</select>
							<?php endif; ?>
							<?php if($v['memLv'] == 10){echo "관리자";}?>
						</td>
						<td><?=$v['memId']?></td>
						<td><?=$v['memNm']?></td>
						<td><?=$v['memAdMain']." ".$v['memAdRemain']?></td>
						<td><?=$v['memPh']?></td>
						<td><?=$v['memEm']?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<input type='submit' value='선택 일괄 변경하기' onclick="return confirm('정말 변경하시겠습니까?');">
	</form>
</div>

<?=$pagination?>