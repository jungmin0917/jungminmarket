<div class='mypage_index_wrap layout_width'>
	<div class='title'>마이페이지</div>
	<div class='info_box'>
		<div class='left'>
			<div class='profile'>

			</div>
		</div>
		<div class='right'>
			<div class='text1'>환영합니다. <?=$memNm?> 회원님!</div>
			<div class='text2'>
				<a href='<?=siteUrl("order/list")?>'><i class='xi-won'></i>주문내역</a>ㆍ<a href='<?=siteUrl("order/basket")?>'><i class='xi-cart-o'></i>장바구니</a>ㆍ<a href='<?=siteUrl("mypage/wishlist")?>'><i class='xi-gift-o'></i>관심상품</a>
			</div>
			<div class='text3'>
				총 주문 : 회<br>
				예치금 : 원<br>
				가용 포인트 : 원<br>
				사용 포인트 : 원
			</div>
		</div>
	</div>

	<div class='benefit_info'>
		<div class='left'>
			회원님의 혜택정보
		</div>

		<div class='right'>
			<div class='bar'></div>
			저희 쇼핑몰을 이용해주셔서 감사합니다. <?=$memNm?>
			<?php if($memLv == '0'){echo "회원님은 일반 등급 회원이십니다.";}?>
			<?php if($memLv == '1'){echo "회원님은 패밀리 등급 회원이십니다.";}?>
			<?php if($memLv == '2'){echo "회원님은 VIP 등급 회원이십니다.";}?>
			<?php if($memLv == '3'){echo "회원님은 VVIP 등급 회원이십니다.";}?>
			<?php if($memLv == '10'){echo "회원님은 관리자입니다.";}?>
		</div>
	</div>

</div>