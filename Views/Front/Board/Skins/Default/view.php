<div class='board_view_wrap layout_width'>
	<input type='hidden' name='postNo' id='postNo' value='<?=$postNo?>'>
	<input type='hidden' name='boardId' id='boardId' value='<?=$boardId?>'>
	<div class='title'><?=$boardNm?></div>
	<div class='sub_title'><?=$boardNm?> 게시판</div>
	
	<ul class='board_view_ul'>
		<div class='float_left'>
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
					번호
				</div>
				<div class='content'>
					<?=$postNo?>
				</div>
			</li>
			<li>
				<div class='title'>
					조회수
				</div>
				<div class='content'>
					<?=$views?>
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
				<div class='title'>
					게시일
				</div>
				<div class='content'>
					<?=$regDt?>
					<span class='modDt'><?php if($modDt){echo "(*수정됨 ".$modDt.")";}?></span>
				</div>
			</li>
		</div>

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
					echo "<div class='file_content'><a href='".siteUrl("file/download?file={$fileList[$i]['fileName']}")."' target='_blank'>{$fileList[$i]['fileName']}</a></div>";
					echo "</li>";
				}
			}

			if(isset($isImageExists) && $isImageExists){
				$file = App::load(\Component\Core\File::class);

				$fileList = $file->getImageList($fileGroup);

				for($i=0;$i<count($fileList);$i++){
					echo "<li>";
					echo "<div class='file_title'>이미지파일".($i+1)."</div>";
					echo "<div class='file_content'><a href='".siteUrl("file/download?file={$fileList[$i]['fileName']}")."' target='_blank'>{$fileList[$i]['fileName']}</a></div>";
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

		<div class='comment_list_box' name='comment_list_box' id='comment_list_box'>
			<?=$commentList?>
		</div>

		<?php
			if(getSession('member_memNo')){
				echo "
				<div class='comment_form_box'>
					<div class='title'>댓글 달기</div>
					<form method='post' id='comment_form' name='comment_form'>
						<input type='hidden' name='mode' value='write'>
						<input type='hidden' name='postNo' value='{$postNo}'>
						<input type='hidden' name='boardId' value='{$boardId}'>
						<ul>
							<li>
								<textarea name='comment'></textarea>
								<button type='button' class='comment_submit'>확인</button>
							</li>
						</ul>
					</form>
				</div>
				";
			}else{
				echo "
				<div class='comment_form_box'>
					<div class='comment_info'>댓글을 작성하기 위해서는 로그인이 필요합니다</div>
				</div>
				";
			}
		?>

		<?php
			$board = App::load(\Component\Board\Board::class);

			$prevPost = $board->getPrevPost($boardId, $postNo);
			$nextPost = $board->getNextPost($boardId, $postNo);

			if($prevPost){
				echo "<li class='prev_li'>";
				echo "<div class='title post'><i class='xi-angle-up-min'></i> 이전글</div>";
				echo "<div class='content post'>";
				echo "<a href='".siteUrl("board/view?id={$boardId}&post={$prevPost['postNo']}")."'>{$prevPost['subject']}</a>";
				echo "</div>";
				echo "</li>";
			}

			if($nextPost){
				echo "<li class='next_li'>";
				echo "<div class='title post'><i class='xi-angle-down-min'></i> 다음글</div>";
				echo "<div class='content post'>";
				echo "<a href='".siteUrl("board/view?id={$boardId}&post={$nextPost['postNo']}")."'>{$nextPost['subject']}</a>";
				echo "</div>";
				echo "</li>";
			}
		?>
	</ul>

</div>