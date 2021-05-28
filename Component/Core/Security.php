<?php

namespace Component\Core;

use App;

class Security{

	private $cost = 10;

	public function createHash($pw){
		$hashed_pw = password_hash($pw, PASSWORD_DEFAULT, ['cost' => $this->cost]);

		return $hashed_pw;
	}

	public function compareHash($pw, $hashed_pw){
		$result = password_verify($pw, $hashed_pw);

		return $result;
	}
}