<?php

namespace Component\Core;

use PDO;

class DB extends PDO{
	public function __construct(){

		$config = getConfig();

		$dsn = "mysql:host={$config['host']};dbname={$config['dbname']}";

		parent::__construct($dsn, $config['username'], $config['password']);
	}
}