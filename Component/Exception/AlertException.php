<?php

namespace Component\Exception;

use Exception;

class AlertException extends Exception{

	public function __construct($msg){

		parent::__construct($msg);
	}

	public function __toString(){

		return "<script>alert('".$this->getMessage()."');</script>";
	}
}