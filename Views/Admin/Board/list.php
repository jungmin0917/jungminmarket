<div class='board_list_wrap layout_width'>
	<form method='post' action='indb' target='ifrm_hidden' autocomplete="off" class='board_list_form'>
		<input type='hidden' name='mode' value='updateNameSkin'>
		<table class='board_list_table'>
			<thead>
				<tr>
					<th width='5%'>선택</th>
					<th width='15%'>게시판 아이디</th>
					<th width='15%'>게시판 이름</th>
					<th width='35%'>카테고리</th>
					<th width='15%'>게시판 스킨</th>
					<th width='15%'>등록일자</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($list as $v) : ?>
					<tr>
						<td>
							<input type='checkbox' name='boardNo[<?=$v['boardNo']?>]'>
						</td>
						<td>
							<?=$v['boardId']?>
						</td>
						<td>
							<input type='text' name='boardNm[<?=$v['boardNo']?>]' value='<?=$v['boardNm']?>'>
						</td>
						<td>
							<?php
								$v['category'] = str_replace(PHP_EOL, "|| ", $v['category']);
								echo $v['category'];
							?>
						</td>
						<td>
							<select name='boardSkin[<?=$v['boardNo']?>]'>
								<?php foreach($skins as $skin) : ?>
									<option value='<?=$v['boardSkin']?>'><?=$v['boardSkin']?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td>
							<?php
								$v['regDt'] = str_replace(" ", "<br>", $v['regDt']);
								echo $v['regDt'];
							?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>

		</table>
		<input type='submit' value='선택 일괄 변경하기' onclick="return confirm('정말 변경하시겠습니까?');">
	</form>
</div>

<?=$pagination?>