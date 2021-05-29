$(document).ready(function(){
	console.log('로드됨');

	CKEDITOR.replace("contents");
	
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
});