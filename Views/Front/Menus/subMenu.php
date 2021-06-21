<div class='sub_menu_wrap'>	
	<div class='layout_width'>
		<ul class='sub_menu_left'>
			<li>
				<i class='layer_menu_button xi-bars'>
					<div class='layer_menu'>
						<div class='layer_menu_box'>
							<div class='left'>
								<ul>
									<li>
										<a href='<?=siteUrl("goods/list?category=best")?>'>BEST 30</a>
									</li>
									<li>
										<a href='<?=siteUrl("goods/list?category=new")?>'>NEW 30</a>
									</li>
									<li>
										<a href='<?=siteUrl("goods/list?category=top")?>'>상의</a>
									</li>
									<li>
										<a href='<?=siteUrl("goods/list?category=bottom")?>'>하의</a>
									</li>
									<li>
										<a href='<?=siteUrl("goods/list?category=shoes")?>'>신발</a>
									</li>
									<li>
										<a href='<?=siteUrl("goods/list?category=underwear")?>'>속옷</a>
									</li>
									<li>
										<a href='<?=siteUrl("goods/list?category=accessory")?>'>악세서리</a>
									</li>
								</ul>
							</div>
							<div class='right'>
								<ul>
									<li>
										<a href='#none'>커뮤니티</a>
										<ul>
											<li>
												<a href='<?=siteUrl("board/list?id=notice")?>'>공지사항</a>
											</li>
											<li>
												<a href='<?=siteUrl("board/list?id=event")?>'>이벤트</a>
											</li>
											<li>
												<a href='<?=siteUrl("board/list?id=review")?>'>리뷰</a>
											</li>
											<li>
												<a href='<?=siteUrl("board/list?id=qna")?>'>Q&A</a>
											</li>
										</ul>
									</li>
									<li>
										<a href='#none'>회사정보</a>
										<ul>
											<li>
												<a href='<?=siteUrl("inform/company")?>'>회사소개</a>
											</li>
											<li>
												<a href='<?=siteUrl("inform/terms")?>'>이용약관</a>
											</li>
											<li>
												<a href='<?=siteUrl("inform/privacy")?>'>개인정보처리방침</a>
											</li>
											<li>
												<a href='<?=siteUrl("inform/use")?>'>이용안내</a>
											</li>
										</ul>
									</li>
									
								</ul>
							</div>
						</div>
					</div>
				</i>
			</li>
			<li>
				<a href='<?=siteUrl("goods/list?category=best")?>'>BEST 30</a>
			</li>
			<li>
				<a href='<?=siteUrl("goods/list?category=new")?>'>NEW 30</a>
			</li>
			<li>
				<a href='<?=siteUrl("goods/list?category=top")?>'>상의</a>
			</li>
			<li>
				<a href='<?=siteUrl("goods/list?category=bottom")?>'>하의</a>
			</li>
			<li>
				<a href='<?=siteUrl("goods/list?category=shoes")?>'>신발</a>
			</li>
			<li>
				<a href='<?=siteUrl("goods/list?category=underwear")?>'>속옷</a>
			</li>
			<li>
				<a href='<?=siteUrl("goods/list?category=accessory")?>'>악세서리</a>
			</li>
		</ul>
		<ul class='sub_menu_right'>
			<li>
				<form method='get' target='_self' action='<?=siteUrl("goods/search")?>' autocomplete='off' class='search_form'>
					<label for='search_word'>
						<input type='hidden' name='mode' value='search'>
						<input type='text' id='search_word' name='search_word' placeholder='검색어를 입력하세요'>
					</label>
					<input type='image' src='<?=siteUrl("assets/Front/image/search_icon.png")?>'>
				</form>
			</li>
		</ul>
	</div>
</div>