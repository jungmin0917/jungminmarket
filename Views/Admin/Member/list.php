<div class='member_list_wrap layout_width'>
	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='member_list_form'>
		<input type='hidden' name='mode' value='updateGrade'>
		<table class='member_list_table'>
			<thead>
				<tr>
					<th width='8%'>회원등급</th>
					<th width='15%'>아이디</th>
					<th width='12%'>이름</th>
					<th width='30%'>주소</th>
					<th width='12%'>전화번호</th>
					<th>이메일</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($list as $v) : ?>
					<tr>
						<td>
							<select name=memLv[<?=$v['memNo']?>]>
								<option value='0' <?php if($v['memLv'] == '0'){echo "selected";}?> >일반</option>
								<option value='1' <?php if($v['memLv'] == '1'){echo "selected";}?> >패밀리</option>
								<option value='2' <?php if($v['memLv'] == '2'){echo "selected";}?> >VIP</option>
								<option value='3' <?php if($v['memLv'] == '3'){echo "selected";}?> >VVIP</option>
							</select>
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
		<input type='submit' value='회원등급 일괄 변경하기'>
	</form>
</div>

<?=$pagination?>