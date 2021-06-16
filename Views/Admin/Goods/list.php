<div class='goods_list_wrap layout_width'>
	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='goods_list_table_form'>
		<input type='hidden' name='mode' value='goods_list_update'>
		<table class='goods_list_table'>
			<thead>
				<tr>
					<th width='5%'>
						선택
					</th>
					<th width='7.5%'>
						분류
					</th>
					<th colspan='2' width='25%'>
						상품명
					</th>
					<th width='7.5%'>
						원가
					</th>
					<th width='7.5%'>
						판매가
					</th>
					<th width='7.5%'>
						재고
					</th>
					<th width='7.5%'>
						품절 여부
					</th>
					<th width='7.5%'>
						진열 여부
					</th>
					<th width='20%'>
						관리
					</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($list as $v) : ?>
				<tr>
					<td>
						<input type='checkbox' name='goodsNo[<?=$v['goodsNo']?>]'>
					</td>
					<td>
						<?php
							$sql = "SELECT * FROM jmmk_goods_category WHERE categoryCode = :categoryCode";

							$stmt = db()->prepare($sql);

							$stmt->bindValue(":categoryCode", $v['categoryCode']);

							$result = $stmt->execute();

							$row = $stmt->fetch(PDO::FETCH_ASSOC);

							echo $row['categoryNm'];
						?>
					</td>
					<td class='goodsImg' width='70px'>
						<?php
							$file = App::load(\Component\Core\File::class);
							$fileData = $file->getGoodsImageFileInfo($v['fileGroup']);
							$fileName = $fileData['fileName'];

							echo "<a href='".siteUrl("goods/view?goodsNo={$v['goodsNo']}")."'>";
							echo "<img src='/workspace/jungminmarket/assets/Upload/Image/{$fileName}'>";
							echo "</a>";
						?>
					</td>
					<td class='goodsNm' width='200px'>
						<?=$v['goodsNm']?>
					</td>
					<td>
						<?=$v['defaultPrice']?>
					</td>
					<td>
						<?=$v['salePrice']?>
					</td>
					<td>
						<input type='text' name='stock[<?=$v['goodsNo']?>]' value='<?=$v['stock']?>'>
					</td>
					<td>
						<select name='isSoldout[<?=$v['goodsNo']?>]'>
							<option value='0' <?php if($v['isSoldout'] == '0'){echo "selected";}?> >판매중</option>
							<option value='1' <?php if($v['isSoldout'] == '1'){echo "selected";}?> >품절</option>
						</select>
					</td>
					<td>
						<select name='isDisplay[<?=$v['goodsNo']?>]'>
							<option value='1' <?php if($v['isDisplay'] == '1'){echo "selected";}?> >진열중</option>
							<option value='0' <?php if($v['isDisplay'] == '0'){echo "selected";}?> >미진열</option>
						</select>
					</td>
					<td class='buttons'>
						<a href='<?=siteUrl("admin/goods/update?goodsNo={$v['goodsNo']}")?>'>수정</a>
						<a href='<?=siteUrl("admin/goods/delete?goodsNo={$v['goodsNo']}")?>' onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
						<a href='<?=siteUrl("goods/view?goodsNo={$v['goodsNo']}")?>'>보기</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class='table_list_submit_wrap'>
			<input type='submit' value='선택 일괄 변경하기'>
		</div>
	</form>
	<?=$pagination?>
</div>
