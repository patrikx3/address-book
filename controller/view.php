<?php
namespace Controller;

use Lib\Controller_base;
use Lib\View as Lib_view;

class View extends Controller_base  {

	public function get($view) {
		echo Lib_view::get_view_contents($view);
	}
	
	public function display($view = null) {
		Lib_view::layout($view);
	}

}