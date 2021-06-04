<div class='board_write_wrap layout_width'>
	<div class='title'><?=$boardNm?></div>
	<div class='sub_title'><?=$boardNm?> 게시글을 <?=isset($postNo)?"수정":"작성"?>합니다</div>

	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='board_write_form' id='board_write_form' enctype='multipart/form-data'>
		<input type='hidden' name='mode' value='<?=isset($postNo)?"modify":"write"?>'>
		<input type='hidden' name='boardId' value='<?=$boardId?>'>
		<?php
			if(isset($postNo)){
				echo "<input type='hidden' name='postNo' value={$postNo}>";
			}
		?>
		<ul class='board_write_ul'>
			<li>
				<label for='subject'>제목</label>
				<input type='text' name='subject' id='subject' class='subject' value='<?=isset($postNo)?$subject:""?>'>
			</li>
			<li>
				<textarea name='contents' id='contents'><?=isset($postNo)?$contents:""?></textarea>
			</li>
			<li>
				<label for='file1' class='file'>첨부파일1</label>
				<input type='file' name='file1' id='file1'>
				<?php 
					if(isset($isFileExists) && $isFileExists){
						echo "<span class='notice'>*주의 : 첨부파일을 하나라도 첨부할 시 기존 첨부파일이 삭제됩니다</span>";
					}
				?>

			</li>
			<li>
				<label for='file2' class='file'>첨부파일2</label>
				<input type='file' name='file2' id='file2'>
			</li>
			<?php
				if(isset($isFileExists) && $isFileExists){
					$file = App::load(\Component\Core\File::class);

					$fileList = $file->getFileList($fileGroup);

					for($i=0;$i<count($fileList);$i++){
						echo "<li>";
						echo "<div class='file_title'>기존 첨부파일".($i+1)."</div>";
						echo "<div class='file_content'>{$fileList[$i]['fileName']}</div>";
						echo "</li>";
					}
				}
			?>

			<li class='secure'>
				<label for='secure' class='secure'>비밀글 설정</label>
				<div class='radio'>
					<label for='secure_unlocked'><input type='radio' name='secure' id='secure_unlocked' value='unlocked' checked>공개글</label>
					<label for='secure_locked'><input type='radio' name='secure' id='secure_locked' value='locked'>비밀글</label>
				</div>
			</li>

			<li class='buttons'>
				<div class='left'>
					<a href='<?=siteUrl("board/list?id={$boardId}")?>' onclick="return confirm('저장되지 않은 내용은 없어집니다. 목록으로 돌아가시겠습니까?');">목록</a>
				</div>

				<div class='right'>
					<a href="#none" onclick="document.getElementById('board_write_form').submit();" class='submit'><?=isset($postNo)?"수정":"작성"?></a>
					<a href='<?=siteUrl("board/list?id={$boardId}")?>' onclick="return confirm('정말 취소하시겠습니까?');">취소</a>
				</div>
			</li>
		</ul>
	</form>
</div>