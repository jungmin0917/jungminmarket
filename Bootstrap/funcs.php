<?php

function debug($v){
	echo "<xmp style='font-size:15px; padding:10px; background-color:black; color:lightgreen'>";
	print_r($v);
	echo "</xmp>";
}

function getConfig(){
	$path = __DIR__ . "/../Config/config.ini";

	if(!file_exists($path)){
		return;
	}

	$config = parse_ini_file($path);

	return $config;
}

function siteUrl($url){
	$config = getConfig();

	return $config['mainUrl'].$url;
}

function db(){
	return \App::load(\Component\Core\DB::class);
}

function request(){
	return \App::load(\Component\Core\Request::class);
}

function alertGo($msg, $url, $target = 'self'){
	$config = getConfig();
	$url = $config['mainUrl'].$url;
	echo "<script>alert('{$msg}'); {$target}.location.href='{$url}';</script>";
	exit;
}

function alertBack($msg, $target = 'self'){
	echo "<script>alert('{$msg}'); {$target}.history.back();</script>";
	exit;
}

function alert($msg){
	echo "<script>alert('{$msg}');</script>";
	exit;
}

function go($url, $target = 'self'){
	$config = getConfig();
	$url = $config['mainUrl'].$url;
	echo "<script>{$target}.location.href='{$url}';</script>";
	exit;
}

function alertReplace($msg, $url, $target = 'self'){
	$config = getConfig();
	$url = $config['mainUrl'].$url;
	echo "<script>alert('{$msg}'); {$target}.location.replace('{$url}');</script>";
	exit;
}

function alertReload($msg, $target = 'self'){
	echo "<script>alert('{$msg}'); {$target}.location.reload();</script>";
}

// 세션 추가하는 함수
function setSession($key, $value = null, $expires = 0){
	$_SESSION[$key] = $value;

	if($expires > 0){ // 만료시간 지정한 경우 값이 만료시간 자체가 됨
		$_SESSION['expires_'.$key] = time() + $expires;
	}

	return;
}

// 세션 조회하는 함수
function getSession($key){
	$_SESSION[$key] = $_SESSION[$key] ?? '';

	if(isset($_SESSION['expires_'.$key]) && $_SESSION['expires_'.$key] < time()){ // 현재 시간보다 값이 작을 경우 세션값 비움 (사실상 unset)
		$_SESSION[$key] = [];
		return;
	}

	return $_SESSION[$key];
}

// 로그인 확인하는 함수
function isLogin(){
	if(!getSession('member_memNo')){
		return false;
	}else{
		return true;
	}
}

// 관리자 로그인 확인하는 함수
function isAdminLogin(){
	if(getSession('member_memLv') == 10){
		return true;
	}else{
		return false;
	}
}