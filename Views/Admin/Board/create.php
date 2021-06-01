<div class='board_create_wrap layout_width'>
<form method='post' action='indb' target='ifrm_hidden' autocomplete="off" class='board_create_form'>
	<input type='hidden' name='mode' value='create'>
	<div class='title'>게시판 생성</div>

	<ul class='board_create_ul'>
		<li>
			<label for='boardId'>게시판 아이디</label>
			<input type='text' name='boardId' id='boardId'>
		</li>
		<li>
			<label for='boardNm'>게시판 이름</label>
			<input type='text' name='boardNm' id='boardNm'>
		</li>
		<li>
			<label for='cagetory'>카테고리</label>
			<textarea name='category' id='category' placeholder='카테고리 입력은 엔터키로 분리해주세요'></textarea>
		</li>
		<li>
			<label for='cagetory'>게시판 스킨</label>
			<select name='boardSkin'>
			<?php foreach($skins as $skin) : ?>
				<option value='<?=$skin?>'><?=$skin?></option>
			<?php endforeach; ?>
			</select>
		</li>
	</ul>
	<input type='submit' value='생성하기'>
</div>
</div>