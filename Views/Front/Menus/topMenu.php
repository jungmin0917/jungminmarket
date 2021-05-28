<div class='top_menu_wrap'>
	<div class='layout_width'>
		<ul class='top_menu_left'>
			<li>
				<a href='<?=siteUrl("board_notice/list")?>'>공지사항</a>
			</li>
			<li>
				<a href='<?=siteUrl("board_event/list")?>'>이벤트</a>
			</li>
			<li>
				<a href='<?=siteUrl("board_review/list")?>'>리뷰</a>
			</li>
			<li>
				<a href='<?=siteUrl("board_qna/list")?>'>Q&A</a>
			</li>
		</ul>
		<ul class='top_menu_right'>
			<?php if(isset($_SESSION['member']['memNo'])){
				echo "<li class='hello'>";
				echo "<span class='name'>".$_SESSION['member']['memNm']."</span>님, 반갑습니다";
				echo "</li>";
			}?>
			<li>
				<?php if(isset($_SESSION['member']['memNo'])){ echo "<a href='".siteUrl("member/logout")."'>로그아웃</a>"; } else{ echo "<a href='".siteUrl("member/login")."'>로그인</a>"; }?>
			</li>
			<li>
				<?php if(isset($_SESSION['member']['memNo'])){ echo "<a href='".siteUrl("member/modify")."'>정보수정</a>"; } else{ echo "<a href='".siteUrl("member/join")."'>회원가입</a>"; }?>
			</li>
			<li>
				<a href='<?=siteUrl("order/basket")?>'>장바구니</a>
			</li>
			<li>
				<a href='<?=siteUrl("order/list")?>'>주문내역</a>
			</li>
			<li>
				<a href='<?=siteUrl("mypage/index")?>'>마이페이지</a>
			</li>
		</ul>
	</div>
</div>

<div class='title_logo'>
	<a href='<?=siteUrl("")?>'>
		<img src='<?=siteUrl("assets/Front/image/title_logo.png")?>'>
	</a>
</div>