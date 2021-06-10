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
		<li class='comment'>
			<?=$v['comment']?>
		</li>
	</ul>
	<?php endforeach; ?>
</div>
<?php endif; ?>