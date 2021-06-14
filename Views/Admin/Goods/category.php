<div class='goods_category_wrap layout_width'>
	<div class='title'>분류 설정</div>
	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='goods_category_form'>
		<input type='hidden' name='mode' value='category_create'>
		<ul class='goods_category_ul'>
			<li>
				<label for='categoryCode'>분류 코드</label>
				<input type='text' id='categoryCode' name='categoryCode'>
			</li>
			<li>
				<label for='categoryNm'>분류명</label>
				<input type='text' id='categoryNm' name='categoryNm'>
			</li>
		</ul>
		<div class='goods_category_submit_wrap'>
			<input type='submit' value='등록하기'>
		</div>
	</form>

	<table class='goods_category_table'>
		<thead>
			<tr>
				<th width='5%'>선택</th>
				<th width='20%'>분류 코드</th>
				<th width='30%'>분류명</th>
				<th width='20%'>진열 여부</th>
				<th width='15%'>등록일자</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($categoryList as $v) : ?>
			<tr>
				<td>
					<input type='checkbox' name="categoryNo[<?=$v['categoryNo']?>]">
				</td>
				<td>
					<?=$v['categoryCode']?>
				</td>
				<td>
					<?=$v['categoryNm']?>
				</td>
				<td>
					<label for='isDisplayOn'>
						<input type='radio' name='isDisplay[<?=$v['categoryNo']?>]' id='isDisplayOn' value='1' <?php if($v['isDisplay'] == '1'){echo "checked";}?> >진열
					</label>
					<label for='isDisplayOff'>
						<input type='radio' name='isDisplay[<?=$v['categoryNo']?>]' id='isDisplayOff' value='0' <?php if($v['isDisplay'] == '0'){echo "checked";}?> >미진열
					</label>
				</td>
				<td>
					<?=date("Y-m-d", strtotime($v['regDt']))?><br>
					<?=date("H:i:s", strtotime($v['regDt']))?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>