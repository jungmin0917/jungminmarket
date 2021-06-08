<?php

namespace Controller\Front\File;

use App;

class UploadController extends \Controller\Front\FrontController{
	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		$fileGroup = request()->get('fileGroup');
		App::render("Front/File/upload", ['fileGroup' => $fileGroup]);
	}
}