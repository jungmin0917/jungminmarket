<div class='order_list_wrap layout_width'>
	<div class='title'>주문 목록</div>

	<div class='order_list_table_wrap'>
		<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='order_list_table_form'>
			<input type='hidden' name='mode' value='update'>
			<table class='order_list_table'>
				<thead>
					<tr>
						<th width='5%'>
							선택
						</th>
						<th width='10%'>
							주문번호
						</th>
						<th width='10%'>
							주문상태
						</th>
						<th width='20%'>
							주문자명
						</th>
						<th width='20%'>
							결제금액
						</th>
						<th width='20%'>
							결제방법
						</th>
						<th width='15%'>
							등록일자
						</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach($orderList as $k => $v) : ?>
					<tr>
						<td>
							<input type='checkbox' name='orderNo[<?=$v['orderNo']?>]'>
						</td>
						<td>
							<?=$v['orderNo']?>
						</td>
						<td>
							<select name='orderStatus[<?=$v['orderNo']?>]'>
								<option value='주문접수' <?php if($v['orderStatus'] == '주문접수'){echo "selected";}?> >주문접수</option>
								<option value='입금확인' <?php if($v['orderStatus'] == '입금확인'){echo "selected";}?> >입금확인</option>
								<option value='배송준비' <?php if($v['orderStatus'] == '배송준비'){echo "selected";}?> >배송준비</option>
								<option value='배송중' <?php if($v['orderStatus'] == '배송중'){echo "selected";}?> >배송중</option>
								<option value='배송완료' <?php if($v['orderStatus'] == '배송완료'){echo "selected";}?> >배송완료</option>
								<option value='구매확정' <?php if($v['orderStatus'] == '구매확정'){echo "selected";}?> >구매확정</option>
							</select>
						</td>
						<td>
							<?php
								$member = App::load(\Component\Member\Member::class);

								$memberInfo = $member->getMember($v['memNo']);
							?>
							<?=$memberInfo['memNm']?>
						</td>
						<td>
							<?php
								$totalPrice = 0;

								foreach($v['goodsData'] as $k2 => $v2){
									$totalPrice = $totalPrice + $v2['totalGoodsPrice'];
								}
							?>
							<?=number_format($totalPrice)?>원
						</td>
						<td>
							<?=$v['paymentMethod']?>
						</td>
						<td>
							<?=date("Y-m-d", strtotime($v['regDt']))?><br>
							<?=date("H:i:s", strtotime($v['regDt']))?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>

			</table>
			<div class='order_list_submit_wrap'>
				<input type='submit' value='선택 일괄 변경하기'>
			</div>
		</form>
	</div>
	<?=$pagination?>
</div>