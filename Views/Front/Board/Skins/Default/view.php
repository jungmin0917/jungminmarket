<div class='board_view_wrap layout_width'>
	<div class='title'><?=$boardNm?></div>
	<div class='sub_title'><?=$boardNm?> 게시판</div>
	
	<ul class='board_view_ul'>
		<li>
			<div class='title'>
				제목
			</div>
			<div class='content'>
				<?=$subject?>
			</div>
		</li>
		<li>
			<div class='title'>
				작성자
			</div>
			<div class='content'>
				<?=$memNm?>
			</div>
		</li>
		<li>
			<div class='contents'>
				<?=$contents?>
			</div>
		</li>
		<?php
			if(isset($isFileExists) && $isFileExists){
				$file = App::load(\Component\Core\File::class);

				$fileList = $file->getFileList($fileGroup);

				for($i=0;$i<count($fileList);$i++){
					echo "<li>";
					echo "<div class='file_title'>첨부파일".($i+1)."</div>";
					echo "<div class='file_content'><a href='".siteUrl("file/download?file={$fileList[$i]['fileName']}")."'; target='_blank'>{$fileList[$i]['fileName']}</a></div>";
					echo "</li>";
				}
			}
		?>

		<li class='buttons'>
			<div class='left'>
				<a href='<?=siteUrl("board/list?id={$boardId}")?>'>목록</a>
			</div>

			<div class='right'>
				<a href='<?=siteUrl("board/modify?id={$boardId}&post={$postNo}")?>' class='modify'>수정</a>
				<a href='<?=siteUrl("board/delete?id={$boardId}&post={$postNo}")?>' onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
			</div>
		</li>

		<?php
			$board = App::load(\Component\Board\Board::class);

			$prevPost = $board->getPrevPost($boardId, $postNo);
			$nextPost = $board->getNextPost($boardId, $postNo);

			if($prevPost){
				echo "<li>";
				echo "<div class='title post'><i class='xi-angle-up-min'></i> 이전글</div>";
				echo "<div class='content post'>";
				echo "<a href='".siteUrl("board/view?id={$boardId}&post={$prevPost['postNo']}")."'>{$prevPost['subject']}</a>";
				echo "</div>";
				echo "</li>";
			}

			if($nextPost){
				echo "<li>";
				echo "<div class='title post'><i class='xi-angle-down-min'></i> 다음글</div>";
				echo "<div class='content post'>";
				echo "<a href='".siteUrl("board/view?id={$boardId}&post={$nextPost['postNo']}")."'>{$nextPost['subject']}</a>";
				echo "</div>";
				echo "</li>";
			}
		?>
	</ul>

</div>