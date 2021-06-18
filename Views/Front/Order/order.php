<section class='order_order_wrap layout_width'>
	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='order_order_form'>
		<input type='hidden' name='mode' value='order'>
		<div class='title'>주문하기</div>

		<div class='sub_title'>주문 상품</div>

		<div class='order_order_table_wrap'>
			<table class='order_order_table'>
				<thead>
					<tr>
						<th colspan='2' width='50%'>상품명</th>
						<th width='20%'>수량</th>
						<th width='30%'>금액</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($cartData as $k => $v) : ?>
					<tr>
						<td width='9%' class='goodsImg'>
							<?php
								$file = App::load(\Component\Core\File::class);

								$fileInfo = $file->getGoodsImageFileInfo($v['goodsData']['fileGroup']);

								echo "<img src='/workspace/jungminmarket/assets/Upload/Image/{$fileInfo['fileName']}'>";
							?>
						</td>
						<td class='goodsNm'>
							<?=$v['goodsData']['goodsNm']?>
						</td>
						<td class='goodsCount'>
							<?=$v['goodsCount']?>
						</td>
						<td class='totalPrice'>
							<?=number_format($v['goodsCount'] * $v['goodsData']['salePrice'])?>원
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<div class='sub_title'>주문자 정보</div>
		<div class='order_info_box'>
			<ul class='order_info_ul'>
				<li>
					<label for='orderName'>주문자 이름</label>
					<input type='text' name='orderName' id='orderName' value='<?=$memberData['memNm']?>'>
				</li>
				<li>
					<label for='orderPhone'>주문자 전화번호</label>
					<input type='text' name='orderPhone' id='orderPhone' value='<?=$memberData['memPh']?>'>
				</li>
				<li>
					<label for='orderEmail'>주문자 이메일</label>
					<input type='text' name='orderEmail' id='orderEmail' value='<?=$memberData['memEm']?>'>
				</li>
			</ul>
		</div>

		<div class='sub_title'>배송지 정보</div>
		<div class='receiver_info_box'>
			<ul class='receiver_info_ul'>
				<li>
					<label for='receiverName'>수신자 이름</label>
					<input type='text' name='receiverName' id='receiverName' value=''>
				</li>
				<li>
					<label for='receiverPhone'>수신자 전화번호</label>
					<input type='text' name='receiverPhone' id='receiverPhone' value=''>
				</li>
				<li>
					<label for='receiverAd_search'>수신자 주소</label>
					<ul class='receiverAd_ul'>
						<li>
							<input type='text' name='receiverAdNum' id='receiverAdNum' readonly placeholder='우편번호'>
							<input type='button' value='주소검색' id='receiverAd_search'>
						</li>
						<li>
							<input type='text' name='receiverAdMain' id='receiverAdMain' readonly placeholder='기본주소'>
						</li>
						<li>
							<input type='text' name='receiverAdRemain' id='receiverAdRemain' placeholder='나머지 주소'>
						</li>
					</ul>
				</li>
			</ul>
		</div>

		<div class='sub_title'>결제 정보</div>
		<div class='payment_info_box'>
			<ul class='payment_info_ul'>
				<li>
					<label>주문상품 금액</label>
					<div></div>
				</li>
				<li>
					<label>배송비</label>
					<div></div>
				</li>
				<li>
					<label>결제금액</label>
					<div></div>
				</li>
				<li>
					<label>결제수단</label>
					<div>
						<label for='paymentMethod1'>
							<input type='radio' name='paymentMethod' id='paymentMethod1' class='paymentMethod1' value='무통장입금'>무통장입금
						</label>
						<label for='paymentMethod2'>
							<input type='radio' name='paymentMethod' id='paymentMethod2' class='paymentMethod2' value='신용카드'>신용카드
						</label>
						<label for='paymentMethod3'>
							<input type='radio' name='paymentMethod' id='paymentMethod3' class='paymentMethod3' value='가상계좌'>가상계좌
						</label>
					</div>
				</li>
				<li class='paymentMethod1_li'>
					<label for='bankAccount'>입금계좌</label>
					<div>
						<select name='bankAccount'>
							<option value='shinhan'>신한 110-354-937017 황정민</option>
							<option value='nonghyup'>농협 123-456-789012 황정민</option>
						</select>
						<input type='text' name='bankDepositor' placeholder='입금자명'>
					</div>
				</li>
			</ul>
		</div>
	</form>

</section>