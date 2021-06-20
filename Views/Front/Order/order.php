<section class='order_order_wrap layout_width'>
	<div class='title'>주문하기</div>
	<form method='post' action='indb' target='ifrm_hidden' autocomplete='off' class='order_order_form'>
		<input type='hidden' name='mode' value='order'>

		<?php foreach($cartData as $k => $v) : ?>
			<input type='hidden' name='cartNo[]' value='<?=$k?>'>
		<?php endforeach; ?>

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
				<tfoot>
					<tr>
						<th colspan='2' width='30%'>
							총 합계
						</th>
						<th width='20%'>
							배송비
						</th>
						<th width='50%'>
							최종
						</th>
					</tr>
					<tr>
						<td class='totalPrice' colspan='2' width='30%'>
							<?=number_format($totalPrice)?>원
						</td>
						<td class='deliveryFee' width='20%'>
							<?=number_format($deliveryFee)?>원
						</td>
						<td class='finalPrice' width='50%'>
							<?=number_format($totalPrice + $deliveryFee)?>원
						</td>
					</tr>
				</tfoot>
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
					<select name='orderPhone[]' id='orderPhone_1'>
						<option value='010' <?php if($memPhArray[0] == '010'){echo "selected";}?> >010</option>
						<option value='011' <?php if($memPhArray[0] == '011'){echo "selected";}?> >011</option>
						<option value='016' <?php if($memPhArray[0] == '016'){echo "selected";}?> >016</option>
						<option value='017' <?php if($memPhArray[0] == '017'){echo "selected";}?> >017</option>
						<option value='018' <?php if($memPhArray[0] == '018'){echo "selected";}?> >018</option>
						<option value='019' <?php if($memPhArray[0] == '019'){echo "selected";}?> >019</option>
					</select>
					<input type='text' name='orderPhone[]' id='orderPhone_2' value='<?=$memPhArray[1]?>' class='orderPhone_input' maxlength='4'>
					<input type='text' name='orderPhone[]' id='orderPhone_3' value='<?=$memPhArray[2]?>' class='orderPhone_input' maxlength='4'>

				</li>
				<li>
					<label for='orderEmail'>주문자 이메일</label>
					<input type='email' name='orderEmail' id='orderEmail' value='<?=$memberData['memEm']?>'>
				</li>
			</ul>
		</div>

		<div class='sub_title'>배송지 정보</div>

		<label for='isEqual' class='isEqual'><input type='checkbox' id='isEqual' class='isEqual'>주문자 정보와 같음</label>
		
		<div class='receiver_info_box'>
			<ul class='receiver_info_ul'>
				<li>
					<label for='receiverName'>수신자 이름</label>
					<input type='text' name='receiverName' id='receiverName' value=''>
				</li>
				<li>
					<label for='receiverPhone'>수신자 전화번호</label>
					<select name='receiverPhone[]' id='receiverPhone_1'>
						<option value='010'>010</option>
						<option value='011'>011</option>
						<option value='016'>016</option>
						<option value='017'>017</option>
						<option value='018'>018</option>
						<option value='019'>019</option>
					</select>
					<input type='text' name='receiverPhone[]' id='receiverPhone_2' class='receiverPhone_input' maxlength='4'>
					<input type='text' name='receiverPhone[]' id='receiverPhone_3' class='receiverPhone_input' maxlength='4'>
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
					<div><?=number_format($totalPrice)?>원</div>
				</li>
				<li>
					<label>배송비</label>
					<div><?=number_format($deliveryFee)?>원</div>
				</li>
				<li>
					<label>결제금액</label>
					<div class='finalPrice'><?=number_format($totalPrice + $deliveryFee)?>원</div>
				</li>
				<li>
					<label>결제수단</label>
					<div class='paymentMethod'>
						<label for='paymentMethod1'>
							<input type='radio' name='paymentMethod' id='paymentMethod1' class='paymentMethod1' value='무통장입금' checked>무통장입금
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
		<div class='order_order_form_submit_wrap'>
			<input type='submit' value='주문하기' onclick="return confirm('정말 주문하시겠습니까?');">
		</div>
	</form>

</section>