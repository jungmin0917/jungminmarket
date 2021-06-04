<?php

namespace Controller\Front\File;

use App;

class DownloadController extends \Controller\Front\FrontController{

	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		$fileName = request()->get('file');
		$file = App::load(\Component\Core\File::class);

		$file->download($fileName);
	}
}