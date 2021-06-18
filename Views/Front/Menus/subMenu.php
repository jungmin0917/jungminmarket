<div class='sub_menu_wrap'>	
	<div class='layout_width'>
		<ul class='sub_menu_left'>
			<li>
				<i class='layer_menu xi-bars'></i>
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
				<form method='get' target='_self' action='<?=siteUrl("goods/search")?>' class='search_form'>
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