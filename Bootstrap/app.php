<?php

$instances = [];

class App{

	public static function load($nsp, ...$args){
		$GLOBALS['instances'][$nsp] = $GLOBALS['instances'][$nsp] ?? '';
		$args = $args ?? '';

		if(!$GLOBALS['instances'][$nsp]){
			$class = new ReflectionClass($nsp);
			$GLOBALS['instances'][$nsp] = $class->newInstanceArgs($args);
		}

		return $GLOBALS['instances'][$nsp];
	}

	public static function routes(){

		$nsp = '';

		$uri = $_SERVER['REQUEST_URI'];

		$config = getConfig();

		$uri = str_replace($config['mainUrl'], "", $uri);

		if(preg_match("/[?~]/", $uri)){
			$pattern = "/.+?(?=[?~])/";

			preg_match($pattern, $uri, $matches);

			$uri = $matches[0];
		}

		$path = explode("/", $uri);

		$type = '';
		$folder = '';
		$file = '';

		if(count($path) == 1 && empty($path[0])){ // 프론트 메인 페이지
			$type = "Front";
			$folder = "main";
			$file = "index";
		}else if(count($path) == 1 && strtolower($path[0]) == "admin"){ // 어드민 메인 페이지
			$type = "Admin";
			$folder = "main";
			$file = "index";
		}else if(count($path) == 1){ // 프론트 각 폴더 메인 페이지
			$type = "Front";
			$folder = $path[0];
			$file = "index";
		}else if(count($path) == 2 && strtolower($path[0]) == "admin"){ // 어드민 각 폴더 메인 페이지
			$type = "Admin";
			$folder = $path[1];
			$file = "index";
		}else if(count($path) == 2){ // 프론트 각 페이지
			$type = "Front";
			$folder = $path[0];
			$file = $path[1];
		}else if(count($path) == 3 && strtolower($path[0]) == "admin"){ // 어드민 각 페이지
			$type = "Admin";
			$folder = $path[1];
			$file = $path[2];
		}

		$folder = ucfirst($folder);
		$file = ucfirst($file);

		$nsp = "\\Controller\\{$type}\\{$folder}\\{$file}Controller";

		if(!class_exists($nsp)){
			$nsp = "\\Controller\\Front\\Error\\Error404Controller";
		}

		$controller = self::load($nsp);

		if(method_exists($controller, 'isAdmin')){
			$controller->isAdmin();
		}

		$controller->header();

		if(method_exists($controller, 'topMenu')){
			$controller->topMenu();
		}

		if(method_exists($controller, 'subMenu')){
			$controller->subMenu();
		}
		
		$controller->index();

		if(method_exists($controller, 'footerMenu')){
			$controller->footerMenu();
		}

		$controller->footer();

	}

	public static function render($skinPath, $data = []){
		
		if(!$skinPath){
			return;
		}

		if($data && is_array($data)){
			extract($data);
		}

		$mainPath = __DIR__ . "/../Views/";

		$path = $mainPath . $skinPath . ".php";

		if(!file_exists($path)){
			return;
		}

		ob_start();
		include_once $path;
		$content = ob_get_clean();
		echo $content;
	}

	public static function includeFiles($dirs = []){

		$list = [];

		if(!$dirs){
			return $list;
		}

		$list[] = __DIR__ . "/../Controller/Controller.php";
		$list[] = __DIR__ . "/../Controller/Admin/AdminController.php";
		$list[] = __DIR__ . "/../Controller/Front/FrontController.php";

		foreach($dirs as $dir){
			$fileList = glob($dir."/*");

			foreach($fileList as $file){
				$file_pi = pathinfo($file);

				if(isset($file_pi['extension']) && $file_pi['extension'] == 'php'){
					$list[] = $file;
				}else if(is_dir($file)){
					$_list = self::includeFiles([$file]);

					if($_list){
						$list = array_merge($list, $_list);
					}
				}
			}
		}

		$list = array_unique($list);
		return $list;
	}
}