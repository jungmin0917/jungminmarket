
<?php if($commentList) : ?>
<div class='comment_list_wrap'>
	<?php foreach($commentList as $v) : ?>
	<ul>
		<li class='memNm'>
			<?=$v['memNm']?>
		</li>		
		<li class='regDt'>
			<?=$v['regDt']?>
		</li>
		<li class='buttons'>
			<?php if(getSession('member_memNo') == $v['memNo']) : ?>
			
				<a href="javascript:;" name='comment_modify'>수정</a>
				<a href="javascript:;" name='comment_delete'>삭제</a>

			<?php endif; ?>
		</li>

		<li class='comment'>
			<?=$v['comment']?>
		</li>
	</ul>
	<?php endforeach; ?>
</div>
<?php endif; ?>