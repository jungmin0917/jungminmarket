<div class='board_write_wrap layout_width'>
	<div class='title'><?=$boardNm?></div>
	<div class='sub_title'><?=$boardNm?> 게시글을 작성합니다</div>

	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='board_write_form' id='board_write_form' enctype='multipart/form-data'>
		<input type='hidden' name='mode' value='write'>
		<input type='hidden' name='boardId' value='<?=$boardId?>'>
		<ul class='board_write_ul'>
			<li>
				<label for='subject'>제목</label>
				<input type='text' name='subject' id='subject' class='subject'>
			</li>
			<li>
				<textarea name='contents' id='contents'></textarea>
			</li>
			<li>
				<label for='file_1' class='file'>첨부파일1</label>
				<input type='file' name='file_1' id='file_1'>
			</li>
			<li>
				<label for='file_2' class='file'>첨부파일2</label>
				<input type='file' name='file_2' id='file_2'>
			</li>

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
					<a href="#none" onclick="document.getElementById('board_write_form').submit();" class='submit'>작성</a>
					<a href='<?=siteUrl("board/list?id={$boardId}")?>' onclick="return confirm('정말 취소하시겠습니까?');">취소</a>
				</div>
			</li>
		</ul>
	</form>
</div>