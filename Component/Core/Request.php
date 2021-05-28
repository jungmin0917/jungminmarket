<?php

namespace Component\Core;

use App;

class Request{

	private $_get;
	private $_post;
	private $_files;

	public function __construct(){
		$this->_get = $_GET;
		$this->_post = $_POST;
		$this->_files = $_FILES;

		return $this;
	}

	public function get($key = null){
		$this->_get[$key] = $this->_get[$key] ?? '';

		if($key){
			return $this->_get[$key];
		}else{
			return $this->_get;
		}
	}

	public function post($key = null){
		$this->_post[$key] = $this->_post[$key] ?? '';
		
		if($key){
			return $this->_post[$key];
		}else{
			return $this->_post;
		}
	}

	public function files(){
		return $this->_files;
	}

	public function all(){
		return array_merge($this->_get, $this->_post);
	}
}