<?php

class ufront_web_mvc_view_FormatHelper implements ufront_web_mvc_IViewHelper{
	public function __construct() { 
	}
	public function register($data) {
		$data->set("format", (isset(thx_core_Dynamics::$format) ? thx_core_Dynamics::$format: array("thx_core_Dynamics", "format")));
		$data->set("pattern", (isset(thx_core_Strings::$format) ? thx_core_Strings::$format: array("thx_core_Strings", "format")));
		$data->set("formatDate", (isset(thx_core_Dates::$format) ? thx_core_Dates::$format: array("thx_core_Dates", "format")));
		$data->set("formatInt", (isset(thx_core_Ints::$format) ? thx_core_Ints::$format: array("thx_core_Ints", "format")));
		$data->set("formatFloat", (isset(thx_core_Floats::$format) ? thx_core_Floats::$format: array("thx_core_Floats", "format")));
	}
	function __toString() { return 'ufront.web.mvc.view.FormatHelper'; }
}
