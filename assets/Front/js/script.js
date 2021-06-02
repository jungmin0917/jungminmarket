$(document).ready(function(){
	console.log('로드됨');

    /* CKEDITOR 관련 */
	CKEDITOR.replace("contents");

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

    $('body').on('click', '#email', function(){
        $(this).closest('ul').find('.email').removeClass('none');
        $(this).closest('ul').find('.phone').removeClass('none').addClass('none');
    });

    $('body').on('click', '#phone', function(){
        $(this).closest('ul').find('.phone').removeClass('none');
        $(this).closest('ul').find('.email').removeClass('none').addClass('none');
    });

    /* 아이디 찾기 관련 E */

});