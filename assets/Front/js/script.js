$(document).ready(function(){

	console.log('로드됨');

    /* CKEDITOR 관련 */
	var myeditor = CKEDITOR.replace("contents", {
        height:400,
    });

    /* 메인 페이지 swiper 관련 */

    // 배너 swiper
    var swiper = new Swiper(".mySwiper_banner", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },

        loop:true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
    });


    // 베스트 상품 swiper

    var swiper = new Swiper(".mySwiper_best", {
        slidesPerView: 3,
        spaceBetween: 20,

        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },

        loop:true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
    });

	/* 약관 관련 */
	$('body').on('click', '#agree_all', function(){
		if($(this).is(":checked")){
			$(this).closest('.member_join_agree').find("input[type='checkbox']").prop('checked', true);
		}else{
			$(this).closest('.member_join_agree').find("input[type='checkbox']").prop('checked', false);
		}
	});

	/* 주소 검색 관련 */
	$('body').on('click', '#memAd_search', function(){
		execDaumPostcode();
	});

	function execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                $('#memAdNum').val(data.zonecode);
                $('#memAdMain').val(data.address);
            }
        }).open();
    }

    /* input 실시간 유효성 검사 관련 S */

    $('body').on('blur', '.input_validator', function(){
        member.validator($(this));
    });

    const member = {
    	/**
    	*	회원 가입 유효성 검사
    	*
    	*	@param obj = $this
    	*/
    	validator : function(obj){
    		const name = obj.attr('name');
    		if(name == 'memPwRe'){
    			this.checkRePassword();
    			return;
    		}

    		const value = obj.val();
    		$li = obj.closest("li");

    		$.ajax({
    			url : "/workspace/jungminmarket/member/ajax",
    			type : "post",
    			dataType : "json",
    			data : {
    				mode : "join",
    				column : name,
    				value : value,
    			},
    			success : function(res){
    				// 메세지 출력
    				$msg = $li.find(".msg");
    				if($msg.length == 0){ // .msg 요소가 없는 경우 추가
    					$li.append("<div class='msg'></div>");
    					$msg = $li.find(".msg");
    				}

    				$msg.text("*" + res.message);

                    if(res.isPass){ // 성공 시 error 클래스 제거
                        $msg.removeClass("error").addClass("success");
                    }else{ // 유효성 검사 실패 시 error 클래스 추가하여 부가 스타일 적용 //
                        $msg.removeClass("success").addClass("error");
                    }
    			},
    			error : function(err){
    				console.error(err);
    			}
    		});
    	},

    	checkRePassword : function(){
    		const memPw = $("input[name='memPw']").val();
    		const memPwRe = $("input[name='memPwRe']").val();
    		$li = $("input[name='memPwRe']").closest("li");

    		$li.removeClass("success").removeClass("error");
    		let msg = "";

    		// 비밀번호 확인 란에 데이터가 있는 경우만 체크
    		if(memPwRe){
                $msg = $li.find(".msg");
                if($msg.length == 0){
                    $li.append("<div class='msg'></div>");
                    $msg = $li.find(".msg");
                }

    			if(memPw != memPwRe){
    				$msg.removeClass("success").addClass("error");
    				msg = "비밀번호가 일치하지 않습니다";
    			}else{
    				$msg.removeClass("error").addClass("success");
    				msg = "비밀번호가 일치합니다";
    			}

    			$msg.text("*" + msg);

    		}else{
                $msg = $li.find(".msg");
                if($msg.length == 0){
                    $li.append("<div class='msg'></div>");
                    $msg = $li.find(".msg");
                }

                $msg.addClass("error");
                msg = "비밀번호 확인을 입력해주세요";
                $msg.text("*" + msg);
            }
    	}
    };

    /* input 실시간 유효성 검사 관련 E */


    /* 아이디 찾기 관련 S */

    $('.member_findid_ul').on('click', '#email', function(){
        $(this).closest('ul').find('.email').removeClass('none');
        $(this).closest('ul').find('.phone').removeClass('none').addClass('none');
    });

    $('.member_findid_ul').on('click', '#phone', function(){
        $(this).closest('ul').find('.phone').removeClass('none');
        $(this).closest('ul').find('.email').removeClass('none').addClass('none');
    });

    /* 아이디 찾기 관련 E */


    /* 첨부파일 삭제 버튼 관련 S */

    $('.board_write_ul').on('click', '#delete_file', function(){
        if($(this).is(":checked")){
            $(this).closest('ul').find('.attach_file').removeClass('none').addClass('none');
            $(this).closest('ul').find("input[type='file']").attr('disabled', true).val('');
        }else{
            $(this).closest('ul').find('.attach_file').removeClass('none');
            $(this).closest('ul').find("input[type='file']").attr('disabled', false);
        }
    });

    /* 첨부파일 삭제 버튼 관련 E */


    /* 이미지 업로드 관련 S */

    $('.board_write_ul').on('click', '#image', function(){
        layer_open();
        var fileGroup = $("input[name='fileGroup']").val(); // fileGroup 따와서 upload 페이지의 쿼리스트링 값으로 사용
        var html = "<iframe class='iframeImage' src='/workspace/jungminmarket/file/upload?fileGroup=" + fileGroup + "'></iframe>";
        $('.layer_popup').html(html);
    });

    // 팝업 바깥 부분 눌렀을 때
    $('body').on('click', '.black', function(){
        layer_close();
    });

    // esc키 눌렀을 때
    $(document).keydown(function(e){
        if($('.black').hasClass('dn') == false){ // 팝업이 켜져 있을 때
            if(e.keyCode == 27){ // 누른 키가 esc키일 때
                layer_close();
            }
        }
    });


    /* 업로드한 이미지 추가 삽입 */

    $('.attach_image').on('click', '.addImage', function(){
        $fileBox = $(this).closest('.file_box');

        const url = $fileBox.data('url');
        const tag = `<img src='${url}'>`;
        CKEDITOR.instances.contents.insertHtml(tag);
    });


    /* 업로드한 이미지 삭제 */

    $('.attach_image').on('click', '.remove', function(){
        if(!confirm("정말 삭제하시겠습니까?")){
            return;
        }

        $fileBox = $(this).closest('.file_box');
        const fileNo = $fileBox.data('fileno');
        const url = $fileBox.data('url');

        $.ajax({
            url: "/workspace/jungminmarket/file/delete",
            type: "post",
            data: {
                fileNo : fileNo
            },
            dataType: "text",
            success: function(res){
                if(res == 1){ // echo 1 반환 시
                    $fileBox.remove(); // 해당 file_box 태그 없앰

                    var data = myeditor.editable().$;
                    $(data).find(`img[src='${url}']`).remove();

                }else{ // echo 0 반환 시
                    alert("파일 삭제 실패");
                }
            },
            error: function(err){
                console.error(err);
            }
        });
    });


    /* 게시판 댓글 등록 S */

    $('.comment_form_box').on('click', '.comment_submit', function(){
        const $form = $('#comment_form');

        $.ajax({
            url: "/workspace/jungminmarket/comment/write",
            type: "post",
            data: $form.serialize(),
            dataType: "html", // 반송되는 데이터 타입
            success: function(res){
                // res는 rendering된 html인데 그걸 원하는 곳에 붙여넣음
                $(".comment_list_box").html(res);
                $form.find('textarea').val(''); // 댓글 쓴 것 지우기
            },
            error: function(err){
                console.error(err);
            }
        });
    });

    // 엔터 치면 위의 함수 수행하도록 하기
    $('.comment_form_box').find('textarea').keypress(function(e){
        if(e.which == 13){
            $('.comment_form_box').find('.comment_submit').click();
            return false; // return false는 실제 엔터키 입력(개행) 자체는 안 되도록
        }
    });

    /* 게시판 댓글 등록 E */


    /* 게시판 댓글 수정 S */

    // 수정 폼 출력 관련
    $('.comment_list_box').on('click', '.comment_modify', function(){
        const commentNo = $(this).closest('ul').attr('class');
        const postNo = $(this).closest('.board_view_wrap').find('#postNo').val();
        const boardId = $(this).closest('.board_view_wrap').find('#boardId').val();

        $this = $(this); // this를 미리 담아줘야 내가 가리키는 this로 쓸 수 있음

        $.ajax({
            url: "/workspace/jungminmarket/comment/modify",
            type: "post",
            data: {
                mode : "formCreate",
                commentNo : commentNo,
                postNo : postNo,
                boardId : boardId,
            },
            dataType: "html",
            success: function(res){
                $this.closest('.comment_list_box').find('.comment_modify_box').remove();
                $this.closest('ul').after(res);
            },
            error: function(err){
                console.error(err);
            }
        });
    });

    // 수정 확인 관련
    $('.comment_list_box').on('click', '.comment_modify_submit', function(){
        const commentNo = $(this).closest('ul').attr('class');
        const postNo = $(this).closest('.board_view_wrap').find('#postNo').val();
        const boardId = $(this).closest('.board_view_wrap').find('#boardId').val();
        const comment = $(this).closest('form').find('textarea').val();

        $this = $(this);

        $.ajax({
            url: "/workspace/jungminmarket/comment/modify",
            type: "post",
            data: {
                mode : "modify",
                commentNo : commentNo,
                postNo : postNo,
                boardId : boardId,
                comment : comment,
            },
            dataType: "html",
            success: function(res){
                $(".comment_list_box").html(res);
            },
            error: function(err){
                console.error(err);
            }
        });
    });

    // 수정 확인 엔터 버튼으로 처리
    $('.comment_list_box').on('keypress', 'textarea', function(e){
        if(e.which == 13){
            $('.comment_list_box').find('.comment_modify_submit').click();
            return false;
        }
    });

    // 수정 취소 관련
    $('.comment_list_box').on('click', '.comment_modify_cancel', function(){
        if(!confirm('정말 취소하시겠습니까?')){
            return false;
        }
        $(this).closest('.comment_list_box').find('.comment_modify_box').remove();
    });

    /* 게시판 댓글 수정 E */


    /* 게시판 댓글 삭제 S */

    $('.comment_list_box').on('click', '.comment_delete', function(){
        if(!confirm('정말 삭제하시겠습니까?')){
            return false;
        }

        const commentNo = $(this).closest('ul').attr('class');
        const postNo = $(this).closest('.board_view_wrap').find('#postNo').val();
        const boardId = $(this).closest('.board_view_wrap').find('#boardId').val();

        $.ajax({
            url: "/workspace/jungminmarket/comment/delete",
            type: "post",
            data: {
                commentNo : commentNo,
                postNo : postNo,
                boardId : boardId,
            },
            dataType: "html",
            success: function(res){
                $(".comment_list_box").html(res);
            },
            error: function(err){
                console.error(err);
            }
        });
    });

    /* 게시판 댓글 삭제 E */


    /* 게시판, 상품 검색 관련 S */

    // 게시판에서 검색한 글자 색깔 바꾸기
    const searchWord = $('#searchWord').val(); // 일단 검색값 가져옴
    const searchWord2 = $('#searchWord2').html();

    if(searchWord){ // 검색어가 있을 때
        // 해당 검색값 앞뒤로 span 붙여서 꾸미기
        const span_before = "<span class='searched'>";
        const span_after = "</span>";

        const pattern = searchWord;

        const regexAll = new RegExp(pattern, "g");

        // 여기서부턴 모든 리스트 일일이 바꾸기
        const htmlList = $('.board_list_table').find('.first');

        for(i=0; i<htmlList.length; i++){
            var html = $('.board_list_table').find('.first').eq(i).html();

            html = html.replace(regexAll, span_before+searchWord+span_after);

            $('.board_list_table').find('.first').eq(i).html(html);
        }
    }

    if(searchWord2){
        // 해당 검색값 앞뒤로 span 붙여서 꾸미기
        const span_before = "<span class='searched'>";
        const span_after = "</span>";

        const pattern = searchWord2;

        const regexAll = new RegExp(pattern, "g");

        const htmlList2 = $('.goods_list_ul').find('.first');

        for(i=0; i<htmlList2.length; i++){
            var html = $('.goods_list_ul').find('.first').eq(i).html();

            html = html.replace(regexAll, span_before+searchWord2+span_after);

            $('.goods_list_ul').find('.first').eq(i).html(html);
        }
    }

    /* 게시판, 상품 검색 관련 E */



    /* 상품 보기 - 상품 가격 계산 관련 S */

    // 최초 로딩 시 할인율 계산해서 넣기

    if($('.goods_view_wrap').length > 0){ // 해당 요소가 있을 때만, 초기 로딩 시
        var defaultPrice = $('.goods_view_wrap').find('.defaultPrice').html();
        defaultPrice = defaultPrice.replace(/[^0-9]/g, "");
        var salePrice = $('.goods_view_wrap').find('.salePrice').html();
        salePrice = salePrice.replace(/[^0-9]/g, "");

        var discountRate = Math.round((1 - salePrice / defaultPrice) * 100); // 반올림하기 (Math.round)

        $('.goods_view_wrap').find('.discountRate').html(discountRate);


        // 최초 로딩 시 1개 가격 넣기
        var price = $('.goods_view_wrap').find('.salePrice').html();
        price = price.replace(/[^0-9]/g, "");
        commaPrice = Number(price).toLocaleString('ko-KR'); // 바꿀 값이 숫자여야 함
        $('.goods_view_wrap').find('.price_number').html(commaPrice);


        // 최초 로딩 시 총 가격 구하기

        var total = 0; // 총 가격 초기화

        var prices = $('.goods_view_wrap').find('.price_number').each(function(index, item){
            var price = $(item).html();
            price = Number(price.replace(/[^0-9]/g, ""));

            total += price;
        });

        total = Number(total).toLocaleString('ko-KR');
        $('.goods_view_wrap').find('.total_price').html(total);
    }

    // 상품 보기에서 input 내 값 변경 시 계산해서 총 가격 넣기
    $('.goods_view_wrap').on('change paste', '.goods_count_input', function(){
        var price = $(this).closest('.goodsInfo').find('.salePrice').html();
        var count = $(this).val();

        if(count < 1){ // 1 미만 입력 방지
            $(this).val(1);
            count = 1;
        }

        if(count > 10){ // 10 초과 입력 방지
            $(this).val(10);
            count = 10;
        }

        price = price.replace(/[^0-9]/g, "");

        var totalPrice = price * count;

        totalPrice = Number(totalPrice).toLocaleString('ko-KR'); // 한국 단위로 콤마 붙이기 (toLocaleString 함수)

        $(this).closest('.item_count').find('.price_number').html(totalPrice); // 넣기


        // 상품 총 계산 가격 변경하기
        var total = 0; // 총 가격 초기화

        $('.goods_view_wrap').find('.price_number').each(function(index, item){
            var price = $(item).html();
            price = Number(price.replace(/[^0-9]/g, ""));

            total += price;
        });

        total = Number(total).toLocaleString('ko-KR');
        $(this).closest('.goodsInfo').find('.total_price').html(total);
    });

    /* 상품 보기 - 상품 가격 계산 관련 E */

    /* 상품 보기 - 상품 바로구매 관련 S */

    $('.goods_view_box').on('click', '.buy_now', function(){
        $(this).closest('form').find("input[name='mode']").val('buy_now');
        $(this).closest('form').attr('action', '/workspace/jungminmarket/order/order');
        $(this).closest('form').attr('target', '_self');

        $(this).closest('form').submit();
    });

    /* 상품 보기 - 상품 바로구매 관련 E */


    /* 상품 보기 - 상품 장바구니 관련 S */

    $('.goods_view_box').on('click', '.add_cart', function(){
        $(this).closest('form').find("input[name='mode']").val('add_cart');

        $(this).closest('form').submit();
    });

    /* 상품 보기 - 상품 장바구니 관련 E */


    /* 상품 보기 - 관심상품 넣기 관련 S */

    $('.goods_view_box').on('click', '.add_wishlist', function(){
        $(this).closest('form').find("input[name='mode']").val('add_wishlist');
        
        $(this).closest('form').submit();
    });

    /* 상품 보기 - 관심상품 넣기 관련 E */


    /* 장바구니 - 금액 계산 관련 S */

    // 초기 로딩 시 구매금액 및 포인트 넣기

    // 장바구니 페이지에서만 해당 스크립트 사용함
    if($('.order_cart_table_wrap').length > 0){ // 초기 로딩 시
        $('.order_cart_table_wrap').find('.goods_count_input').each(function(index, item){
            var goodsPrice = $(item).closest('tr').find("input[type='checkbox']").data('price');

            var goodsCount = $(item).closest('tr').find('.goods_count_input').val();

            var goodsTotalPrice = goodsPrice * goodsCount;

            goodsTotalPriceString = Number(goodsTotalPrice).toLocaleString('ko-KR');

            $(item).closest('tr').find('.goodsTotalPrice').find('.price').html(goodsTotalPriceString);

            // 포인트는 상품 금액의 1%로 해서 계산하기 (반올림)

            var rewardPoint = Math.round(goodsTotalPrice / 100);

            rewardPoint = Number(rewardPoint).toLocaleString('ko-KR');

            $(item).closest('tr').find('.rewardPoint').find('.price').html(rewardPoint);

        });

        // 총 가격 계산
        var totalPrice = 0;

        $('.order_cart_table_wrap').find('.goodsTotalPrice').find('.price').each(function(index, item){
            var price = $(item).html();

            price = price.replace(/[^0-9]/g, "");

            price = Number(price);

            totalPrice += price;
        });

        totalPriceString = Number(totalPrice).toLocaleString('ko-KR');

        totalPriceString = totalPriceString + "원";

        $('.order_cart_price_table').find('.total_price').html(totalPriceString);

        var deliveryFee = 3000;

        deliveryFeeString = Number(deliveryFee).toLocaleString('ko-KR');

        deliveryFeeString = deliveryFeeString + "원";

        $('.order_cart_price_table').find('.delivery_fee').html(deliveryFeeString);

        var finalPrice = 0;

        finalPrice = totalPrice + deliveryFee;

        finalPriceString = Number(finalPrice).toLocaleString('ko-KR');

        finalPriceString = finalPriceString + "원";

        $('.order_cart_price_table').find('.final_price').html(finalPriceString);
    }




    // 장바구니에서 input 내 값 변경 시 계산해서 총 가격 넣기
    $('.order_cart_table_wrap').on('click', "input[type='checkbox']", function(){
        updateTotal($(this));
    });

    $('.order_cart_table_wrap').on('change paste', '.goods_count_input', function(){
        updateTotal($(this));
    });

    function updateTotal(obj){
        // ajax로 장바구니 값 변경 시 DB의 값도 업데이트 해야 함
        $this = obj;
        const ajax_cartNo = $this.closest('tr').find('.cartNo_input').val();
        const ajax_goodsCount = $this.closest('tr').find('.goods_count_input').val();

        $.ajax({
            url: "/workspace/jungminmarket/goods/updateCart",
            type: 'post',
            data: {
                cartNo : ajax_cartNo,
                goodsCount : ajax_goodsCount,
            },
            dataType: 'html',
            success: function(res){
                if(res == 1){

                }else{
                    alert('장바구니 값 변경 처리 실패');
                }
            },
            error: function(err){
                console.error(err);
            }
        });

        var count = $this.val();

        if(count < 1){ // 1 미만 입력 방지
            $this.val(1);
            count = 1;
        }

        if(count > 10){ // 10 초과 입력 방지
            $this.val(10);
            count = 10;
        }

        var goodsPrice = $this.closest('tr').find("input[type='checkbox']").data('price');

        var goodsCount = $this.closest('tr').find('.goods_count_input').val();

        var goodsTotalPrice = goodsPrice * goodsCount;

        goodsTotalPriceString = Number(goodsTotalPrice).toLocaleString('ko-KR');

        $this.closest('tr').find('.goodsTotalPrice').find('.price').html(goodsTotalPriceString);

        // 포인트는 상품 금액의 1%로 해서 계산하기 (반올림)

        var rewardPoint = Math.round(goodsTotalPrice / 100);

        rewardPoint = Number(rewardPoint).toLocaleString('ko-KR');

        $this.closest('tr').find('.rewardPoint').find('.price').html(rewardPoint);


        // 총 가격 계산
        var totalPrice = 0;

        $('.order_cart_table_wrap').find("input[type='checkbox']:checked").each(function(index, item){
            var price = $(item).closest('tr').find('.goodsTotalPrice').find('.price').html();

            price = price.replace(/[^0-9]/g, "");

            price = Number(price);

            totalPrice += price;
        });

        totalPriceString = Number(totalPrice).toLocaleString('ko-KR');

        totalPriceString = totalPriceString + "원";

        $('.order_cart_price_table').find('.total_price').html(totalPriceString);

        var deliveryFee = 3000;

        deliveryFeeString = Number(deliveryFee).toLocaleString('ko-KR');

        deliveryFeeString = deliveryFeeString + "원";

        $('.order_cart_price_table').find('.delivery_fee').html(deliveryFeeString);

        var finalPrice = 0;

        finalPrice = totalPrice + deliveryFee;

        finalPriceString = Number(finalPrice).toLocaleString('ko-KR');

        finalPriceString = finalPriceString + "원";

        $('.order_cart_price_table').find('.final_price').html(finalPriceString);
    };

    /* 장바구니 - 금액 계산 관련 E */



    /* 장바구니 - 각종 버튼 관련 S */

    // 장바구니 비우기 버튼
    $('.order_cart_wrap').on('click', '.remove_all', function(){
        if(!confirm('정말 비우시겠습니까?')){
            return;
        }
        // 먼저 mode 값을 remove_all로 바꿔주기
        $('.order_cart_wrap').find('.order_cart_form').find("input[name='mode']").val('remove_all');

        $('.order_cart_wrap').find('.order_cart_form').submit();
    });


    // 선택 상품 삭제 버튼
    $('.order_cart_wrap').on('click', '.remove_select', function(){
        if(!confirm('정말 삭제하시겠습니까?')){
            return;
        }
        // mode 값 remove_select로 바꾸기
        $('.order_cart_wrap').find('.order_cart_form').find("input[name='mode']").val('remove_select');

        $('.order_cart_wrap').find('.order_cart_form').submit();
    });

    // 각 상품 우측에 주문하기 버튼으로 주문
    $('.order_cart_wrap').on('click', '.order_select_item', function(){
        // 내가 누른 버튼 제외하면 전부 check를 해제하기 (모두 체크 해제 후 내가 누른 것만 체크 다시 해주기)
        $(this).closest('form').find('.cartNo_input').prop('checked', false);
        $(this).closest('tr').find('.cartNo_input').prop('checked', true);

        // form의 action 값을 order로 바꿔주기
        $('.order_cart_wrap').find('.order_cart_form').attr('action', 'order');
        $('.order_cart_wrap').find('.order_cart_form').attr('target', '_self');

        // 먼저 mode 값을 remove_all로 바꿔주기
        $('.order_cart_wrap').find('.order_cart_form').find("input[name='mode']").val('order_select_item');

        $('.order_cart_wrap').find('.order_cart_form').submit();
    });

    // 전체 상품 주문 버튼
    $('.order_cart_wrap').on('click', '.order_all', function(){

        // form의 action 값을 order로 바꿔주기
        $('.order_cart_wrap').find('.order_cart_form').attr('action', 'order');
        $('.order_cart_wrap').find('.order_cart_form').attr('target', '_self');

        // 먼저 mode 값을 remove_all로 바꿔주기
        $('.order_cart_wrap').find('.order_cart_form').find("input[name='mode']").val('order_all');

        $('.order_cart_wrap').find('.order_cart_form').submit();
    });

    // 선택 상품 주문 버튼
    $('.order_cart_wrap').on('click', '.order_select', function(){
        $('.order_cart_wrap').find('.order_cart_form').attr('action', 'order');
        $('.order_cart_wrap').find('.order_cart_form').attr('target', '_self');

        $('.order_cart_wrap').find('.order_cart_form').find("input[name='mode']").val('order_select');

        $('.order_cart_wrap').find('.order_cart_form').submit();
    });

    /* 장바구니 - 각종 버튼 관련 E */


    /* 상품목록 - 정렬순서 변경 관련 S */

    $('.goods_list_wrap').on('change', '.sort_method', function(){
        // form으로 감싸서 폼 submit하기
        $('.goods_list_wrap').find('.sort_method_form').submit();
    });

    /* 상품목록 - 정렬순서 변경 관련 E */


    /* 주문하기 - 주소 검색 관련 S */

    $('body').on('click', '#receiverAd_search', function(){
        execDaumPostcode();
    });

    function execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                $('#receiverAdNum').val(data.zonecode);
                $('#receiverAdMain').val(data.address);
            }
        }).open();
    }

    /* 주문하기 - 주소 검색 관련 E */

    /* 주문하기 - 결제수단 선택 관련 S */

    $('.order_order_wrap .paymentMethod').on('click', "input[type='radio']", function(){
        if($(this).val() != '무통장입금'){ // 무통장입금이 아니면 dn 붙여서 없애고
            $(this).closest('ul').find('.paymentMethod1_li').removeClass('dn').addClass('dn');
            // 값도 없애기
            $(this).closest('ul').find("input[type='text']").val('');

        }else{ // 무통장입금이면 dn 없애서 보이게 한다
            $(this).closest('ul').find('.paymentMethod1_li').removeClass('dn');
        }
    });

    /* 주문하기 - 결제수단 선택 관련 E */

    /* 주문하기 - 주문자 정보와 같음 S */

    $('.order_order_wrap').on('click', '#isEqual', function(){
        if($(this).prop('checked') == true){
            const orderName = $('#orderName').val();
            $('#receiverName').val(orderName);

            const orderPhone_1 = $('#orderPhone_1').val();
            $('#receiverPhone_1').val(orderPhone_1);
            const orderPhone_2 = $('#orderPhone_2').val();
            $('#receiverPhone_2').val(orderPhone_2);
            const orderPhone_3 = $('#orderPhone_3').val();
            $('#receiverPhone_3').val(orderPhone_3);

        }else{
            $('#receiverName').val('');
            $('#receiverPhone_1').val('');
            $('#receiverPhone_2').val('');
            $('#receiverPhone_3').val('');
        }
    });

    /* 주문하기 - 주문자 정보와 같음 E */


    /* 메인 페이지 - 위아래로 가기 S */

    $('aside').on('click', '.go_top', function(){
        $('html').animate({scrollTop : 0});
    });

    $('aside').on('click', '.go_down', function(){
        $('html').animate({scrollTop : document.body.scrollHeight});
    });

    /* 메인 페이지 - 위아래로 가기 E */


    /* 메인 페이지 - 레이어 메뉴 관련 S */

    // 마우스 들어왔을 때
    $('.sub_menu_wrap').on('mouseenter', '.layer_menu_button', function(){ 
        $('.layer_menu').fadeIn(200);
    });

    $('.sub_menu_wrap').on('mouseleave', '.layer_menu_button', function(){
        $('.layer_menu').fadeOut(200);
    });

    /* 메인 페이지 - 레이어 메뉴 관련 E */

});

/* 이미지 업로드 후 콜백 */
function fileUploadCallback(data){

    // '이미지 추가' 버튼 아래에 이미지 리스트 추가
    const tag = `<img src='${data.url}'>`;
    CKEDITOR.instances.contents.insertHtml(tag);

    const html = `<div class='file_box' data-fileno='${data.fileNo}' data-url='${data.url}'>
                <i class='addImage xi-file-upload-o'></i><i class='remove xi-file-remove-o'></i>
                <a href='../file/download?file=${data.fileName}' target='_blank'>${data.fileName}</a>
                </div>`;

    $('.attach_image').find('.height').append(html);

    layer_close();
}

// 레이어 팝업 열기
function layer_open(){
    $('.black').removeClass('dn');
    $('.layer_popup').removeClass('dn');
}

// 레이어 팝업 닫기
function layer_close(){
    $('.black').removeClass('dn').addClass('dn');
    $('.layer_popup').removeClass('dn').addClass('dn');
}