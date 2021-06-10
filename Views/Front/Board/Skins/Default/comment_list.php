
<?php if($commentList) : ?>
<div class='comment_list_wrap'>
	<?php foreach($commentList as $v) : ?>
	<ul class='<?=$v['commentNo']?>'>
		<li class='memNm'>
			<?=$v['memNm']?>
		</li>		
		<li class='regDt'>
			<?=$v['regDt']?>
		</li>
		<li class='modDt'>
			<?=$v['modDt']?>
		</li>
		<li class='buttons'>
			<?php if(getSession('member_memNo') == $v['memNo']) : ?>
			
				<a href="javascript:;" class='comment_modify'>수정</a>
				<a href="javascript:;" class='comment_delete'>삭제</a>

			<?php endif; ?>
		</li>

		<li class='comment'>
			<?=$v['comment']?>
		</li>
	</ul>
	<?php endforeach; ?>
</div>
<?php endif; ?>