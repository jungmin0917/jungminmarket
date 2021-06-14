$(document).ready(function(){

	console.log('로드됨');

    /* CKEDITOR 관련 */
	var myeditor = CKEDITOR.replace("contents", {
        height:400,
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

        console.log('test');

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
        console.log('test');
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


    /* 게시판 검색 관련 S */

    // 게시판에서 검색한 글자 색깔 바꾸기
    const searchWord = $('#searchWord').val(); // 일단 검색값 가져옴

    if(searchWord){ // 검색어가 있을 때
        // 해당 검색값 앞뒤로 span 붙여서 꾸미기
        const span_before = "<span class='searched'>";
        const span_after = "</span>";

        const pattern = searchWord;

        const regexAll = new RegExp(pattern, "g");

        /* 이건 한 개만 바꾸기
        var html = $('.board_list_table').find('.first').html();

        html = html.replace(regexAll, span_before+searchWord+span_after);

        $('.board_list_table').find('.first').html(html);
        */

        // 여기서부턴 모든 리스트 일일이 바꾸기
        const htmlList = $('.board_list_table').find('.first');

        for(i=0; i<htmlList.length; i++){
            var html = $('.board_list_table').find('.first').eq(i).html();

            html = html.replace(regexAll, span_before+searchWord+span_after);

            $('.board_list_table').find('.first').eq(i).html(html);
        }
    }

    /* 게시판 검색 관련 E */

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