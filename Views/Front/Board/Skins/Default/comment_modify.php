<div class='comment_modify_box'>
	<div class='title'>댓글 수정</div>
	<form method='post' id='comment_form' name='comment_form'>
		<input type='hidden' name='mode' value='modify'>
		<input type='hidden' name='postNo' value='<?=$commentData['postNo']?>'>
		<input type='hidden' name='boardId' value='<?=$commentData['boardId']?>'>
		<ul class='<?=$commentData['commentNo']?>'>
			<li>
				<textarea name='comment'><?=$commentData['comment']?></textarea>
				<button type='button' class='comment_modify_submit'>수정</button>
				<button type='button' class='comment_modify_cancel'>취소</button>
			</li>
		</ul>
	</form>
</div>