$(document).ready(function(){
    
	console.log('로드됨');

    /* CKEDITOR 관련 */
    var myeditor = CKEDITOR.replace("contents", {
        height:400,
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
    	*	관리자 등록 유효성 검사
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
    			url : "/workspace/jungminmarket/admin/member/ajax",
    			type : "post",
    			dataType : "json",
    			data : {
    				mode : "register",
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


    /* 이미지 업로드 관련 S */

    // 상품 메인 이미지 업로드
    $('.goods_register_wrap').on('click', '.goodsImageSet', function(){
        layer_open();

        const fileGroup = $(this).closest('form').find("input[name='fileGroup']").val();

        const html = "<iframe src='/workspace/jungminmarket/file/upload?fileGroup=" + fileGroup + "'></iframe>";

        $('.layer_popup').html(html);

        // input type hidden으로 goodsImageSet임을 mode로 넣기

        // iframe 로드 후 처리
        $('iframe').on('load', function(){
            const html2 = "<input type='hidden' name='mode' value='goodsImageSet'>";

            $('iframe').contents().find('form').prepend(html2);
        });
    });

    // 상품 상세설명 이미지 업로드
    $('.goods_register_wrap').on('click', '.longDescImageAdd', function(){
        layer_open();

        const fileGroup = $(this).closest('form').find("input[name='fileGroup']").val();

        const html = "<iframe src='/workspace/jungminmarket/file/upload?fileGroup=" + fileGroup + "'></iframe>";

        $('.layer_popup').html(html);
    });


    // 바깥 버튼 부분 누르면 팝업 꺼짐

    $('body').on('click', '.black', function(){
        layer_close();
    });

    /* 이미지 업로드 관련 E */


    // 업로드한 이미지 추가 삽입
    $('.goods_register_ul').on('click', '.addImage', function(){
        const url = $(this).closest('.file_box').data('url');

        const tag = `<img src='${url}'>`;

        CKEDITOR.instances.contents.insertHtml(tag);
    });

    // 업로드한 이미지 삭제
    $('.goods_register_ul').on('click', '.remove', function(){
        if(!confirm('정말 삭제하시겠습니까?')){
            return false;
        }

        $fileBox = $(this).closest('.file_box');
        const fileNo = $fileBox.data('fileno');
        const url = $fileBox.data('url');

        $.ajax({
            url: "/workspace/jungminmarket/file/delete",
            type: 'post',
            data: {
                fileNo : fileNo,
            },
            dataType: 'text',
            success: function(res){
                if(res == 1){
                    $fileBox.remove();

                    var data = myeditor.editable().$;
                    $(data).find(`img[src='${url}']`).remove();

                }else{
                    alert("파일 삭제 실패");
                }
            },
            error: function(err){
                console.error(err);
            }
        });
    });


});

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

// 상품 메인 이미지 업로드 후 콜백
function goodsImageUploadCallback(data){
    const tag = `<img src='${data.url}'>`;

    $('.goodsImage_preview').html(tag);

    layer_close();
}

// CKEDITOR 내 이미지 업로드 후 콜백
function fileUploadCallback(data){
    const tag = `<img src='${data.url}'>`;

    CKEDITOR.instances.contents.insertHtml(tag);

    const html = `<div class='file_box' data-fileno='${data.fileNo}' data-url='/workspace/jungminmarket/assets/Upload/Image/${data.fileName}'>
        <i class="addImage xi-file-upload-o"></i><i class="remove xi-file-remove-o"></i>
        <a href="/workspace/jungminmarket/file/download?file=${data.fileName}">${data.fileName}</a>
        </div>`;

    $('.longDescImageAdd').after(html);

    layer_close();
}