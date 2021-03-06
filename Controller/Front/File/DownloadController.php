<?php

namespace Controller\Front\File;

use App;
use Component\Exception\AlertException;

class DownloadController extends \Controller\Front\FrontController{

	public function __construct(){
		$this->layoutBlank = true;
	}

	public function index(){
		try{
			$fileName = request()->get('file');
			$file = App::load(\Component\Core\File::class);

			$file->download($fileName);
		}catch(AlertException $e){
			echo $e;
			exit;
		}
	}
}