<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name='viewport'>

	<link rel='shortcut icon' href="<?=siteUrl('assets/Front/image/favicon.png')?>">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">
	<link rel='stylesheet' type='text/css' href='<?=siteUrl("assets/Front/css/reset.css")?>'>
	<link rel='stylesheet' type='text/css' href='<?=siteUrl("assets/Front/css/layer_popup_style.css")?>'>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title></title>
</head>
<body>
<div class='file_upload_wrap'>
	<div class='title'>파일 업로드</div>
	<form method='post' action='<?=siteUrl("file/uploadOk?fileGroup={$fileGroup}")?>' target='ifrm_hidden' autocomplete='off' class='file_upload_form' enctype='multipart/form-data'>
		<input type='hidden' name='fileGroup' value='<?=$fileGroup?>'>
		<div class='input_box'>
			<input type='file' name='file'>
		</div>
		<input type='submit' value='추가하기'>
	</form>
</div>
<iframe name='ifrm_hidden' width='100%' height='300px'></iframe>
</body>
</html>