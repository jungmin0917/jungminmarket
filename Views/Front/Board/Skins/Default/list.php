<div class='board_list_wrap layout_width'>
	<div class='title'><?=$boardNm?></div>
	<table class='board_list_table'>
		<thead>
			<tr>
				<th>번호</th>
				<th>작성자</th>
				<th>제목</th>
				<th>게시일</th>
				<th>조회수</th>
			</tr>	
		</thead>

		<tbody>
			<?php foreach($list as $v) : ?>
			<tr>
				<td>
					<?=$v['idx']?>
				</td>
				<td>
					<?=$v['memNm']?>
				</td>
				<td>
					<?=$v['subject']?>
				</td>
				<td>
					<?=$v['regDt']?>
				</td>
				<td>
					<?=$v['views']?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>

	</table>
	<?php if(isAdminLogin()){
	echo "<a href='".siteUrl("board/write?id={$boardId}")."'>글쓰기</a>";
	}?>
</div>

<?=$pagination?>