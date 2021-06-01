<div class='board_list_wrap layout_width'>
	<form method='post' action='indb' target='ifrm_hidden' autocomplete="off" class='board_list_form'>
		<input type='hidden' name='mode' value='updateNameSkin'>
		<table class='board_list_table'>
			<thead>
				<tr>
					<th>게시판 아이디</th>
					<th>게시판 이름</th>
					<th>카테고리</th>
					<th>게시판 스킨</th>
					<th>등록일자</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($list as $v) : ?>
					<tr>
						<td>
							<?=$v['boardId']?>
						</td>
						<td>
							<?=$v['boardNm']?>
						</td>
						<td>
							<?php
								str_replace(PHP_EOL, "<br>", $v['category']);
								echo $v['category'];
							?>
						</td>
						<td>
							<?=$v['boardSkin']?>
						</td>
						<td>
							<?=$v['regDt']?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>

		</table>
		<input type='submit' value='일괄 변경하기'>
	</form>
</div>

<?=$pagination?>