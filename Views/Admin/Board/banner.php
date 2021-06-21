<div class='admin_banner_wrap layout_width'>
	<div class='title'>배너 설정</div>

	<div class='bannerImageSet_box_wrap'>
		<div class='bannerImageSet_box'>
			<ul class='bannerImageSet_ul'>

				<?php for($i=1; $i<=3; $i++) : ?>
				<li>
					<div class='button'>
						<a href='javascript:;' class='bannerImage_<?=$i?>'>배너 등록 (<?=$i?>번)</a>
					</div>

					<div class='preview bannerImagePreview_<?=$i?>'>
						<?php foreach($bannerImageList as $v) : ?>
							<?php if($v && $v['fileGroup'] == "bannerImage_{$i}") : ?>
								<img src='/workspace/jungminmarket/assets/Upload/Image/bannerImage_<?=$i?>'>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</li>
				<?php endfor; ?>
			</ul>
		</div>
	</div>
</div>