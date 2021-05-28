<?php

$dirs = [
	__DIR__ . "/../Component",
	__DIR__ . "/../Controller",
];

$fileList = App::includeFiles($dirs);

foreach($fileList as $file){
	include_once $file;
}
