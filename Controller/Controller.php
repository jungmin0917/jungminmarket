<?php

namespace Controller;

use App;

abstract class Controller{
	abstract function header();
	abstract function index();
	abstract function footer();
}