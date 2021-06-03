<div class='board_list_wrap layout_width'>
	<div class='title'><?=$boardNm?></div>
	<div class='sub_title'><?=$boardNm?> 게시판입니다</div>
	<div class='board_list_table_wrap'>
	<table class='board_list_table'>
		<thead>
			<tr>
				<th width='5%'>번호</th>
				<th width='10%'>작성자</th>
				<th width='30%'>제목</th>
				<th width='10%'>게시일</th>
				<th width='5%'>조회수</th>
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
					<?=date("Y-m-d", strtotime($v['regDt']))?><br>
					<?=date("H:i:s", strtotime($v['regDt']))?>
				</td>
				<td>
					<?=$v['views']?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>

	</table>
	<?php 
		if(isAdminLogin() && ($boardId == 'notice' || $boardId == 'event')){
			echo "<div class='write_button_wrap'>";
			echo "<a href='".siteUrl("board/write?id={$boardId}")."' class='write'>글쓰기</a>";
			echo "</div>";
		}else if($boardId == 'review' || $boardId == 'qna'){
			echo "<div class='write_button_wrap'>";
			echo "<a href='".siteUrl("board/write?id={$boardId}")."' class='write'>글쓰기</a>";
			echo "</div>";
		}
	?>
	</div>
</div>

<?=$pagination?>