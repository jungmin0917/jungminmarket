<div class='goods_register_wrap layout_width'>
	<div class='title'>
		상품 등록 <span class='red'>(* 표시는 필수 입력)</span>
	</div>
	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='goods_register_form'>
		<input type='hidden' name='mode' value='<?php if(isset($goodsData)){echo 'update';} else{echo 'register';}?>'>

		<input type='hidden' name='fileGroup' value='<?php if(isset($goodsData)){echo $goodsData['fileGroup'];} else{echo $fileGroup;}?>'>
		<ul class='goods_register_ul'>
			<li class='isDisplay'>
				<label>진열 여부</label>
				<div class='radio'>
					<label for='isDisplayOn'>
						<input type='radio' name='isDisplay' id='isDisplayOn' value='1' <?php if(isset($goodsData) && $goodsData['isDisplay'] == 1){echo 'checked';}else if(isset($goodsData) && $goodsData['isDisplay'] == 0){echo '';}else{echo 'checked';}?> >진열
					</label>
					<label for='isDisplayOff'>
						<input type='radio' name='isDisplay' id='isDisplayOff' value='0' <?php if(isset($goodsData) && $goodsData['isDisplay'] == 0){echo 'checked';}?> >미진열
					</label>
				</div>
			</li>
			<li class='categoryCode'>
				<label for='categoryCode'>상품 분류</label>
				<select name='categoryCode' id='categoryCode'>
					<?php foreach($categoryList as $v) : ?>
						<option value='<?=$v['categoryCode']?>' <?php if(isset($goodsData) && $goodsData['categoryCode'] == $v['categoryCode']){echo 'selected';}?> ><?=$v['categoryNm']?></option>
					<?php endforeach; ?>
				</select>
			</li>
			<li class='goodsNm'>
				<label for='goodsNm'>상품명 <span class='red'>*</span></label>
				<input type='text' id='goodsNm' name='goodsNm'>
			</li>
			<li class='shortDesc'>
				<label for='shortDesc'>상품 간단설명 <span class='red'>*</span></label>
				<input type='text' id='shortDesc' name='shortDesc'>
			</li>
			<li class='defaultPrice'>
				<label for='defaultPrice'><i class='xi-won'></i>상품 원가 <span class='red'>*</span></label>
				<input type='text' id='defaultPrice' name='defaultPrice'>
			</li>
			<li class='salePrice'>
				<label for='salePrice'><i class='xi-percent'></i>상품 판매가 <span class='red'>*</span></label>
				<input type='text' id='salePrice' name='salePrice'>
			</li>
			<li class='stock'>
				<label for='stock'>상품 재고</label>
				<input type='text' id='stock' name='stock'>
			</li>
			<li class='isSoldout'>
				<label>품절 여부</label>
				<div class='radio'>
					<label for='isSoldoutNo'>
						<input type='radio' name='isSoldout' id='isSoldoutNo' value='0' checked>판매중
					</label>
					<label for='isSoldoutYes'>
						<input type='radio' name='isSoldout' id='isSoldoutYes' value='1'>품절
					</label>
				</div>
			</li>
			<li class='goodsImage'>
				<label for='goodsImage'>이미지 설정 <span class='red'>*</span><br><span class='red'>*1개만 등록 가능합니다<br>추가 이미지는 아래의<br>상세설명에 넣어주세요</span></label>
				<div class='goodsImage_wrap'>
					<input type='button' value='이미지 설정' name='goodsImage' id='goodsImage' class='goodsImageSet'>
					<div class='goodsImage_preview'>
					</div>
				</div>
			</li>
			<li class='longDesc'>
				<label for='contents'>상품 상세설명<br><span class='red'>*이미지는 5개까지<br>등록 가능합니다</span></label>
				<div class='textarea_wrap'>
					<textarea name='longDesc' id='contents'></textarea>
					<div class='file_box_wrap'>
						<input type='button' value='이미지 추가' name='longDescImage' id='longDescImage' class='longDescImageAdd'>
					</div>
				</div>
			</li>
		</ul>
		<div class='goods_register_submit_wrap'>
			<input type='submit' value='등록하기'>
		</div>
	</form>
</div>