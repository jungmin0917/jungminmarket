<div class='goods_register_wrap layout_width'>
	<div class='title'>
		상품 등록
	</div>
	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='goods_register_form'>
		<input type='hidden' name='mode' value='register'>
		<ul class='goods_register_ul'>
			<li class='isDisplay'>
				<label>진열 여부</label>
				<div class='radio'>
					<label for='isDisplayOn'>
						<input type='radio' name='isDisplay' id='isDisplayOn' value='1' checked>진열
					</label>
					<label for='isDisplayOff'>
						<input type='radio' name='isDisplay' id='isDisplayOff' value='0'>미진열
					</label>
				</div>
			</li>
			<li class='categoryCode'>
				<label for='categoryCode'>상품 분류</label>
				<select name='categoryCode' id='categoryCode'>
					
				</select>
			</li>
			<li class='goodsNm'>
				<label for='goodsNm'>상품명</label>
				<input type='text' id='goodsNm' name='goodsNm'>
			</li>
			<li class='shortDesc'>
				<label for='goodsNm'>상품 간단설명</label>
				<input type='text' id='shortDesc' name='shortDesc'>
			</li>

		</ul>
		<input type='submit' value='등록하기'>
	</form>
</div>